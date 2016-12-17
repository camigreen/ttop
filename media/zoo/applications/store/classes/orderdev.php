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
	public $status = 0;
	public $subtotal = 0;
	public $tax_total = 0;
	public $ship_total = 0;
	public $account;
	public $total = 0;

	public $app;

	protected $_user;
	protected $_account;

	public function save($lock = false) {

		$tzoffset = $this->app->date->getOffset();
		$now        = $this->app->date->create();
		$cUser = $this->app->storeuser->get();

    	// set created date
		if(!$this->created) {
			$this->created = $now->toSQL();
		}

		if(!$this->created_by) {
			$this->created_by = $this->app->storeuser->get()->id;
		}

        // Set Modified Date
        $this->modified = $now->toSQL();
        $this->modified_by = $cUser->id; 

        $this->params->set('terms', $this->app->storeuser->get()->getAccount()->params->get('terms', 'DUR'));


        if($lock) {
        	$this->params->set('locked', true);
        	$this->_calculateFinalTotals();
        	foreach($this->elements->get('items.', array()) as $hash => $item) {
	        	$this->elements->set('items.'.$hash, $item->lock());
	        }
        } else {
        	foreach($this->elements->get('items.', array()) as $hash => $item) {
        		$this->elements->set('items.'.$hash, $item->toJson());
	        }
        }

        $this->elements->set('ip', $this->app->useragent->ip());

		$this->table->save($this);

		return $this;

	}

	public function __toString () {
		$result = $this->app->parameter->create();
		$result->loadObject($this);
		$result->remove('app');
		return (string) $result;
	}

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function addItems($items = array()) {
		$items = (array) $items;
		foreach($items as $item) {
			$this->elements->set('items.'.$item->id, $item);
		}
		return $this;
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
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function getItems() {
		return $this->elements->get('items.', array());
	}

	/**
	 * Determines if notifications need to be sent
	 *
	 * @return 	boolean		True or false if notification needs to be sent.
	 *
	 * @since 1.0
	 */
	public function notify() {
		//return !$this->params->get('notifications.'.$type, false);
		return true;
	}

	public function getOrderDate($format = 'DATE_STORE_RECEIPT') {
		return $this->app->html->_('date', $this->created, JText::_($format));
	}

	public function getItemPrice($sku) {
		$item = $this->elements->get('items.'.$sku);
		return $item->getPrice();
	}

	public function getSubtotal($display = 'display') {
		$items = $this->elements->get('items.', array());
		$subtotal = 0;
		foreach($items as $item) {
			$subtotal += $item->getTotalPrice($display);
		}
		return $subtotal;
	}

	public function getShippingTotal() {

		if($this->isProcessed()) {
			return $this->ship_total;
		}

		if(!$service = $this->elements->get('shipping_method')) {
            return 0;
        }
        if($service == 'LP') {
        	return 0;
        }
        $application = $this->app->zoo->getApplication();
        $markup = $application->getParams()->get('global.shipping.ship_markup', 0);
        $markup = intval($markup)/100;
        $ship = $this->app->shipper;
        $ship_to = $this->app->parameter->create($this->elements->get('shipping.'));
        $rates = $ship->setDestination($ship_to)->assemblePackages($this->getItems())->getRates();
        $rate = 0;
        foreach($rates as $shippingMethod) {
            if($shippingMethod->getService()->getCode() == $service) {
                $rate = $shippingMethod->getTotalCharges();
            }
        }
		$rate += ($rate * $markup);

        return $rate;
    }

    public function getTotal($display = 'display') {
    	$total = $this->getSubTotal($display) + $this->getTaxTotal() + $this->getShippingTotal();
    	return $total;
    }

    /**
     * Describe the Function
     *
     * @param 	datatype		Description of the parameter.
     *
     * @return 	datatype	Description of the value returned.
     *
     * @since 1.0
     */
    public function getTotals() {
    	if(!$this->isProcessed() || $this->subtotal == 0) {
    		$this->_calculateFinalTotals();
    		$this->save();
    	}
    	$totals = array();
    	$totals['subtotal'] = $this->subtotal;
    	$totals['taxtotal'] = $this->tax_total;
    	$totals['shiptotal'] = $this->ship_total;
    	$totals['total'] = $this->total;

    	return $this->app->data->create($totals);
    }

    /**
     * Describe the Function
     *
     * @param 	datatype		Description of the parameter.
     *
     * @return 	datatype	Description of the value returned.
     *
     * @since 1.0
     */
    protected function _calculateFinalTotals() {
    	$this->subtotal = $this->getSubTotal('charge');
    	$this->tax_total = $this->getTaxTotal();
    	$this->ship_total = $this->getShippingTotal();
    	$this->total = $this->subtotal + $this->tax_total + $this->ship_total;
    }

	public function isProcessed() {
		return $this->status > 0;
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
		if($this->account) {
			$this->_account = $this->app->account->get($this->account);
		} else {
			$this->_account = $this->app->storeuser->get()->getAccount();
			$this->account = $this->_account->id;
		}
		
		return $this->_account;
	}

	public function getTaxTotal() {
		
		// Init vars
		$taxtotal = 0;
		$taxrate = 0.07;
		if(!$this->isTaxable()) {
			$this->tax_total = 0;
			return $this->tax_total;
		}

		$items = $this->elements->get('items.', array());

		foreach($items as $item) {
			$taxtotal += ($item->isTaxable() ? ($item->getTotalPrice('charge')*$taxrate) : 0);
		}
		
		$this->tax_total = $taxtotal;
		return $this->tax_total;
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