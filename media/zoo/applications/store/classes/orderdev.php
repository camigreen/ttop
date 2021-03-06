<?php defined('_JEXEC') or die('Restricted access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class OrderDev {

	public $id;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $params;
	public $elements;
	public $access = 12;
	public $status = 1;
	public $subtotal = 0;
	public $tax_total = 0;
	public $ship_total = 0;
	public $account;
	public $total = 0;

	public $app;

	protected $_user;
	protected $_account;
	
	public function __construct() {
	}

	public function save($writeToDB = false) {

		$tzoffset = $this->app->date->getOffset();
		$now        = $this->app->date->create();
		$cUser = $this->app->storeuser->get();

    	// set created date
		if(!$this->created) {
			$this->created = $now->toSQL();
		}

        // Set Modified Date
        $this->modified = $now->toSQL();
        $this->modified_by = $cUser->id; 

        $this->params->set('terms', $this->app->storeuser->get()->getAccount()->params->get('terms', 'DUR'));
        if($this->app->storeuser->get()->isReseller()) {
        	$this->getTotal('reseller');
        } else {
        	$this->getTotal('retail');
        }

        $this->elements->set('ip', $this->app->useragent->ip());

		if($writeToDB) {
			$this->table->save($this);
		}

		return $this;

	}

	public function __toString () {
		$result = $this->app->parameter->create();
		$result->loadObject($this);
		$result->remove('app');
		return (string) $result;
	}

	/**
	 * Get the item published status
	 *
	 * @return int The item status
	 *
	 * @since 1.0
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Set the order status
	 *
	 * @param int  $status The new item status
	 * @param boolean $save  If the change should be saved to the database
	 *
	 * @return Order $this for chaining support
	 *
	 * @since 1.0
	 */
	public function setStatus($status, $save = false) {
		if ($this->status != $status) {

			// set status
			$old_status   = $this->status;
			$this->status = $status;

			// autosave order?
			if ($save) {
				$this->app->table->item->save($this);
			}

			// fire event
		    $this->app->event->dispatcher->notify($this->app->event->create($this, 'order:statusChanged', compact('old_status')));
		}

		return $this;
	}

	/**
	 * Determines if notifications need to be sent
	 *
	 * @return 	boolean		True or false if notification needs to be sent.
	 *
	 * @since 1.0
	 */
	public function notify() {
		return !$this->params->get('notifications', false);
	}

	public function getOrderDate($format = 'DATE_STORE_RECEIPT') {
		return $this->app->html->_('date', $this->created, JText::_($format));
	}

	public function getItemPrice($sku) {
		if(!$item = $this->elements->get('items.'.$sku)) {
			$item = $this->app->cart->get($sku);
			$item->getTotal();
		}
		$discount = $this->getAccount()->params->get('discount', 0)/100;
		return $item->total - ($item->total*$discount);
	}

	public function getSubtotal($display = 'retail') {
		if($this->isProcessed()) {
			return $this->subtotal;
		}
		if(!$items = $this->elements->get('items.')) {
			$items = $this->app->cart->getAllItems();
		}
		$this->subtotal = 0;
		foreach($items as $item) {
			$this->subtotal += $item->getTotal($display);
		}
		return $this->subtotal;
	}

	public function getShippingTotal() {
		if($this->isProcessed()) {
			return $this->ship_total;
		}
		if(!$service = $this->elements->get('shipping_method')) {
            return 0;
        }
        if($service == 'LP') {
        	$this->ship_total = 0;
        	return $this->ship_total;
        }
        $this->ship_total = 0;
        $application = $this->app->zoo->getApplication();
        $markup = $application->getParams()->get('global.shipping.ship_markup', 0);
        $markup = intval($markup)/100;
        $ship = $this->app->shipper;
        $ship_to = $this->app->parameter->create($this->elements->get('shipping.'));
        $rates = $ship->setDestination($ship_to)->assemblePackages($this->app->cart->getAllItems())->getRates();
        $rate = 0;
        foreach($rates as $shippingMethod) {
            if($shippingMethod->getService()->getCode() == $service) {
                $rate = $shippingMethod->getTotalCharges();
            }
        }
		$this->ship_total = $rate += ($rate * $markup);

        return $this->ship_total;
    }

    public function getTotal($display = 'retail') {
    	if($this->isProcessed()) {
    		return $this->total;
    	}
    	$this->total = $this->getSubTotal($display) + $this->getTaxTotal() + $this->getShippingTotal();
    	return $this->total;
    }

	public function isProcessed() {
		return $this->status > 1;
	}

	public function getUser() {
		if($this->created_by) {
			$this->_user = $this->app->storeuser->get($this->created_by);
		}
		if(empty($this->_user)) {
			$this->_user = $this->app->storeuser->get();
			$this->created_by = $this->_user->id;
		}
		
		return $this->_user;
	}

	public function getAccount() {
		$this->_account = $this->app->storeuser->get()->getAccount();
		$this->account = $this->_account->id;
		return $this->_account;
	}

	public function getTaxTotal() {

		if($this->isProcessed()) {
			return $this->tax_total;
		}
		
		// Init vars
		$taxtotal = 0;
		$taxrate = 0.07;
		if(!$this->isTaxable()) {
			$this->tax_total = 0;
			return $this->tax_total;
		}

		if(!$items = $this->elements->get('items.')) {
			$items = $this->app->cart->getAllItems();
		}

		foreach($items as $item) {
			$taxtotal += ($item->taxable ? ($this->getItemPrice($item->sku)*$taxrate) : 0);
		}
		
		$this->tax_total = $taxtotal;
		return $this->tax_total;
	}

	public function calculateCommissions() {
		$application = $this->app->zoo->getApplication();
		$application->getCategoryTree();
		$items = $this->elements->get('items.');
		$account = $this->getAccount();
		$oems = $account->getAllOEMs();
		foreach($items as $item) {
			$_item = $this->app->table->item->get($item->id);
			$item_cat = $_item->getPrimaryCategory();
			foreach($oems as $oem) {
				if($item_cat->id == $oem->elements->get('category')) {
					$this->elements->set('commissions.accounts.'.$oem->id, $this->getItemPrice($item->sku)*$oem->elements->get('commission'));
				}
			}
			
		}
	}

	public function isTaxable() {
		//Is the account tax exempt?
        if($this->getAccount()->isTaxExempt()) {
            return false;
        }
        // Check if the shipping state is a taxable state.
        $state = $this->elements->get('shipping.state');
        $taxable = false;
        $taxable_states = array('SC');
        if ($state) {
            $taxable = (in_array($state,$taxable_states));
        }
        // If is is set for local pickup it is considered taxable.
        if($this->elements->get('shipping_method') == 'LP') {
        	$taxable = true;
        }

        return $taxable;
    }

    public function getShippingMethod() {
    	return JText::_('SHIPPING_METHOD_'.$this->elements->get('shipping_method'));
    }

    public function getCreator() {
    	if($this->created_by == 0) {
    		return 'Website';
    	}
    	return $this->getUser()->name;
    }

}