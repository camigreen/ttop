<?php
/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class Description
 *
 * @package Class Package
 */
class TestController extends AppController {

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($default = array()) {

		parent::__construct($default);

        // set table
        $this->table = $this->app->table->account;

        $this->application = $this->app->zoo->getApplication();

        // registers tasks
        //$this->registerTask('receipt', 'display');



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
	public function sessionIn() {

		$user = $this->app->account->get(10);

		var_dump($user);

		$this->app->session->set('account', $user, 'test');
		
	}

	public function clearOrder() {
		$this->app->session->clear('order', 'checkout');
	}

	public function sessionOut() {
		$user = $this->app->session->get('account', array(), 'test');

		var_dump($user);
	}

	public function testList() {
		$test = 'user.dealership';
		list($class, $type) = explode('.',$test.'.',3);
		echo 'Class:</br>';
		var_dump($class);
		echo 'Type:<?br>';
		var_dump($type);
	}

	public function itemTest() {
		$item = $this->app->table->item->get(5);
		$item = $this->app->item->create($item, 'ttopboatcover');
		var_dump($item->getPrice());
		var_dump($item->getPrice()->get('discount'));

	}

	public function testUser() {
		$storeuser = $this->app->storeuser->get();
		if(!$storeuser) {
			$this->app->error->raiseError('USER.001', JText::_('ERROR.USER.001'));
			return;
		}
		// $profile = $storeuser->getUserProfile();
		// $user->profile = $profile;
		// //$storeuser->save();
		echo 'User:</br>';
		var_dump($storeuser);
		echo 'Is Account Admin:</br>';
		var_dump($storeuser->isAccountAdmin());
		echo 'Is Store Admin:</br>';
		var_dump($storeuser->isStoreAdmin());
		echo 'User Can Edit Accounts:</br>';
		var_dump($storeuser->CanEdit('account'));
		echo 'User Can Edit Orders:</br>';
		var_dump($storeuser->CanEdit('order'));
		echo 'User Can Edit Own:</br>';
		var_dump($storeuser->CanEditOwn(0,$storeuser->id));
		echo 'User Can Edit State(Orders):</br>';
		var_dump($storeuser->CanEditState('order'));
		echo 'User Can Edit State(Accounts):</br>';
		var_dump($storeuser->CanEditState('account'));
	}
	public function testAccount() {
		$aid = $this->app->request->get('aid', 'int', false);
		if($aid) {
			$account = $this->app->account->get($aid);
		} else {
			$storeuser = $this->app->storeuser->get();
			$account = $storeuser->getAccount(true);
		}
		$account->addUser('779', true);
		echo 'Account:</br>';
		var_dump($account);
		echo 'Account User IDs:</br>';
		var_dump($account->getUsers());
	}


	public function testCoupon() {

		$coupon = $this->app->coupon->get('TEST');
		$coupon->setParam('discount', (float)'.30');
		$this->app->table->coupon->save($coupon);
		var_dump($coupon);
		var_dump($coupon->getParam('discount'));
		$coupon->isExpired();

		echo $this->app->html->_('calendar', $coupon->getExpirationDate(), 'testdate', 'testdate');
		echo 'Coupon Expired: '.($coupon->isExpired() ? 'Yes' : 'No');
	}

	public function testEmail() {
		if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        $layout = 'testemail';
        $this->oid = $this->app->request->get('oid', 'int', null);

        $this->getView()->addTemplatePath($this->template->getPath())->setLayout($layout)->display();

    }

    public function testEmail2() {
    	$mail = JFactory::getMailer();
    	$to = $this->app->request->get('to', 'string', null);
    	$subject = 'Test Email';
    	$body = 'This is a test email.';
    	$mail->isSMTP();
    	try {
    		$mail->SMTPDebug = 2;
    		$mail->addRecipient($to);
    		$mail->setSubject($subject);
    		$mail->setBody($body);
    		$mail->Send();
    	} catch (phpmailerException $e) {
    		echo $e->errorMessage();
    	} catch (Exception $e) { 
    		echo $e->getMessage();
    	}
    }

	public function testBoatModel() {
		$this->app->document->setMimeEncoding('application/json');

		$make = $this->app->request->get('make', 'string');
		$kind = $this->app->request->get('kind', 'string');
		// $make = 'americat';
		// $kind = 'bsk';
		echo json_encode($this->app->bsk->getModel($kind, $make));
	}

	public function PriceList() {
		$model = $this->app->request->get('m', 'string', null);
		$fabrics = array('7oz', '8oz', '9oz');
		$options = array('conditions' => array("type = 'ttopboatcover' AND state = 1"));
		$_items = $this->app->table->item->all($options);
		$items = $this->app->data->create();
		$product = array();
		foreach($_items as $item) {
			$cat = $item->getPrimaryCategory()->name;
			if($cat == $model) {
				$item = $this->app->item->create($item, 'ttopboatcover');
				
				if(!isset($product[$item->attributes['boat_model']->get('text')])) {
					$product[$item->attributes['boat_model']->get('text')] = array();
				}
				foreach($fabrics as $fabric) {
					$item->options['fabric']->set('value', $fabric);
					$price = $item->getPrice();
					$product[$item->attributes['boat_model']->get('text')][$fabric] = $this->app->number->currency($price->get(),array('currency' => 'USD'));
				}
				
				$items->set($cat, $product);
			}
		}
		$items = (array) $items;
		ksort($items);
		//var_dump($items['Albemarle']);
		//return;
		foreach($items as $cat => $models) {
			echo '<h3 class="uk-text-contrast">'.$cat.'</h3></br>';
			foreach($models as $model => $prices) {
					echo "<h4 class='uk-text-contrast'>$model</h4>";
				foreach($prices as $fabric => $price) {
					echo "<p>$fabric  -  $price</p>";
				}
				
			}
		}
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
	public function changeAccountDiscount() {
		$commit = $this->app->request->get('commit', 'string');
		$d = $this->app->request->get('d', 'int', null);
		$m = $this->app->request->get('m', 'int', null);

		if($commit != 'yes') {
			echo 'Not Committed';
			return;
		}
		$accounts = $this->app->account->all(array('conditions' => 'id != 7'));
		$count = 0;
		foreach($accounts as $account) {
			$count++;
			echo $account->name.'</br>';
			echo 'From</br>';
			var_dump($account->params->get('discount'));
			var_dump($account->params->get('margin'));
			$account->params->set('discount', $d);
			$account->params->set('margin', $m);
			$account->save();
			echo 'To:</br>';
			var_dump($account->params->get('discount'));
			var_dump($account->params->get('margin'));
		}
		echo $count.' Accounts Changed.';
		
	}


}
?>