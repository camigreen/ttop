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

	public function accountDetails() {
		$aid = $this->app->request->get('aid', 'int',  null);
		if($aid) {
			$account = $this->app->account->get($aid);
		} else {
			echo 'Account Not Found!';
		}
		$orders = $this->app->orderdev->getByAccount($aid);
		$totals = $this->app->parameter->create();
		$totals->set('gross', 0);
		$totals->set('net', 0);
		foreach($orders as $order) {
			if($order->id != 7053) {
				continue;
			}
			echo $order->id.'</br>';
			$gross = $totals->get('gross', 0);
			$net = $totals->get('net', 0);
			$totals->set('gross', $gross + $order->total);
			$totals->set('net', $net + $order->subtotal);
			$items = $order->elements->get('items.');
			$discount = $account->params->get('discount');
			$markup = $account->params->get('markup');
			foreach($items as $item) {
				echo $item->name.'</br>';
				echo $item->type.'</br>';
				$item->getPrice();
				$total = $totals->get('items.'.$item->type.'.total', 0);
				$count = $totals->get('items.'.$item->type.'.count', 0);
				$totals->set('items.'.$item->type.'.total', $total + $item->total);
				$totals->set('items.'.$item->type.'.count', $count + 1);
			}
			//$order->save(true);
			 
		}
		
		echo $account->name;
		var_dump($totals);
		// echo 'Gross Sales: '.$this->app->number->currency($totals['gross'],array('currency' => 'USD')).'</br>';
		// echo 'Net Sales: '.$this->app->number->currency($totals['net'],array('currency' => 'USD')).'</br>';
	}

	public function accountList() {
		
		$accounts = $this->app->account->all();
		$orders = $this->app->orderdev->getByAccount(26);
		var_dump($accounts);
		var_dump($orders);
		$total = 0;
		foreach($orders as $order) {
			$total += $order->total;
		}

		var_dump($total);

		// foreach($accounts as $account) {
		// 	echo $account->name;
		// }

	}

	public function testDisplay() {
		$display = $this->app->request->get('display', 'int');
		echo '<div class="ttop-display">'.nextend_smartslider3($display).'</div>';
	}

}
?>