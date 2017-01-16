<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
    Class: DefaultController
        Site controller class
*/
class CheckoutController extends AppController {

    public $account = null;
    public $processCC = 'true';

    
    public function __construct($default = array()) {
        parent::__construct($default);

        // set table
        $this->table = $this->app->table->account;

        // get application
        $this->application = $this->app->zoo->getApplication();

        // get Joomla application
        $this->joomla = $this->app->system->application;

        // get params
        $this->params = $this->joomla->getParams();

        // get pathway
        $this->pathway = $this->joomla->getPathway();

        // set base url
        $this->baseurl = $this->app->link(array('controller' => $this->controller), false);

        $this->cUser = $this->app->storeuser->get();


        $this->cart = $this->app->cart;

        // registers tasks
        $this->registerTask('customer', 'display');
        $this->registerTask('payment', 'display');
        $this->registerTask('confirm', 'display');
        $this->registerTask('save', 'display');
        $this->registerTask('processPayment', 'display');
        $this->registerTask('addCoupon', 'display');
        $this->registerTask('orderNotification', 'orderNotification');
        //$this->registerTask('claimOrder', 'display');
        // $this->taskMap['display'] = null;
        // $this->taskMap['__default'] = null;
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function display($cachable = false, $urlparams = false) {
        $orderID = $this->app->session->get('orderID', null, 'checkout');
        if($this->cart->isEmpty() && !$orderID) {
            $this->setRedirect('/');
        }
        if($this->task != 'receipt') {
            $this->CR = $this->app->cashregister->start();
        }
        $task = $this->task;
        $this->$task();

    }
    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function claimOrder() {
        $oid = $this->app->request->get('oid', 'int');
        $order = $this->app->orderdev->get($oid);
        $user = $order->getUser();
        $this->app->session->set('aliasUser', $user->id, 'storeuser');
        $this->app->cart->clear();
        $cart = $this->app->cart->add($order->elements->get('items.'));
        $this->app->session->set('orderID', $oid, 'checkout');
        $this->task = 'customer';
        $this->display();
    }

    public function addCoupon() {
        
        $order = $this->CR->order;
        $post = $this->app->request->get('post:', 'array', array());
        if(isset($post['params']['coupon.code']) && $post['params']['coupon.code'] != '') {
            $order->params->set('coupon.code', $post['params']['coupon.code']);
            $order->save();
            echo 'Coupon Added';
        } else {
            $order->params->remove('coupon.code');
        }
        
        $this->payment();
    }

    public function customer() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        //var_dump($this->app->session->get('order', array(), 'checkout'));
        $this->app->document->addScript('assets:js/formhandler.js');
        $order = $this->CR->order;
        $account = $order->getAccount();
        //var_dump($account);
        $user = $order->getUser();
        $this->page = 'customer';
        if($account && $account->type != 'store') {
            if(!$order->elements->get('billing.')) {
                $order->elements->set('billing.', $account->elements->get('billing.'));
                $order->elements->set('billing.phoneNumber', $account->elements->get('poc.office_phone'));
                $order->elements->set('billing.altNumber', $account->elements->get('poc.mobile_phone'));
            }
            if(!$order->elements->get('shipping.')) {
                $order->elements->set('shipping.', $account->elements->get('shipping.'));
                $order->elements->set('shipping.phoneNumber', $account->elements->get('poc.office_phone'));
                $order->elements->set('shipping.altNumber', $account->elements->get('poc.mobile_phone'));
            }
            if(!$order->elements->get('email')) {
                $order->elements->set('email', $user->email);
                $order->elements->set('confirm_email', $user->email);
            }
            
        }
        $type = 'customer';

        $this->form = $this->app->form->create(array($this->template->getPath().'/checkout/config.xml', compact('type')));

        $layout = 'checkout';
        $this->task = 'save';
        $this->title = 'Customer Information';
        $this->subtitle = 'Please enter your information below.';
        $this->buttons = array(
            'back' => array(
                    'active' => false
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => 'payment',
                    'disabled' => false,
                    'label' => 'Proceed'
                )
        );

        $this->order = $order;
        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();

    }

    public function payment() {

        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
 
        $this->page = 'payment';

        $order = $this->CR->order;
        $account = $order->getAccount();
        $user = $order->getUser();
        $this->task = 'save';

        if($account && $account->type != 'store') {
            $order->params->set('payment.account_name', $account->name);
            $order->params->set('payment.account_number', $account->elements->get('account_number'));
            $this->app->session->set('order',(string) $order,'checkout');
        }

        $this->app->document->addScript('assets:js/formhandler.js');

        $layout = 'checkout';

        $type = $this->page;

        $this->form = $this->app->form->create(array($this->template->getPath().'/checkout/config.xml', compact('type')));
        
        $this->title = 'Payment Information';
        $this->subtitle = 'Please enter your payment information below.';
        $this->buttons = array(
            'back' => array(
                    'active' => true,
                    'next' => 'customer',
                    'disabled' => false,
                    'label' => 'Back'
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => 'confirm',
                    'disabled' => false,
                    'label' => 'Proceed'
                )
        );

        $this->order = $order;

        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();

    }

    public function confirm() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }

        $this->app->document->addScript('assets:js/formhandler.js');

        $order = $this->CR->order;
        $account = $order->getAccount();
        $user = $order->getUser();
        $next = 'processPayment';
        $this->task = 'processPayment';
        $layout = 'checkout';
        $this->page = 'confirm';
        if($account && $account->type != 'store') {
            
        }
        

        
        $this->title = 'Order Confirmation';
        $this->subtitle = '<span class="uk-text-danger">Please make sure that your order is correct.</span>';
        $this->buttons = array(
            'back' => array(
                    'active' => true,
                    'next' => 'payment',
                    'disabled' => false,
                    'label' => 'Back'
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => $next,
                    'disabled' => false,
                    'label' => 'Proceed'
                )
        );

        

        

        $this->order = $order;

        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();
    }

    public function receipt() {
        if (!$this->template = $this->application->getTemplate()) {
            return $this->app->error->raiseError(500, JText::_('No template selected'));
        }
        if(!$id = $this->app->request->get('orderID', 'int', 0)) {
            return $this->app->error->raiseError(500, JText::_('Unable to locate that order.'));
        }
        $this->app->document->addScript('assets:js/formhandler.js');
        $order = $this->app->orderdev->get($id);
        $account = $order->getAccount();
        $layout = 'checkout';
        $this->page = 'receipt';
        $this->task = 'home';
        $this->title = 'Order Receipt';
        $this->subtitle = 'Thank you for your purchase.';
        $this->buttons = array(
            'back' => array(
                    'active' => false,
                    'next' => 'payment',
                    'disabled' => false,
                    'label' => 'Back'
                ),
            'proceed' => array(
                    'active' => true,
                    'next' => 'home',
                    'disabled' => false,
                    'label' => 'Return to Home Page'
                )
        );
        $this->order = $order;
        $this->getView()->addTemplatePath($this->template->getPath().'/checkout')->setLayout($layout)->display();
    }

    public function processPayment () {
        $terms = $this->app->storeuser->get()->getAccount()->getParam('terms', 'DUR');
        $order = $this->CR->processPayment($terms);
        $this->app->document->setMimeEncoding('application/json');
        $result = array(
            'approved' => $order->params->get('payment.approved'),
            'orderID' => $order->id,
            'message' => $order->params->get('payment.response_text')
        );
        echo json_encode($result);
    }

    public function getPDF() {
        $id = $this->app->request->get('id','int');
        if (!$order = $this->app->orderdev->get($id)) {
            return $this->app->error->raiseError(10000, JText::_('ERROR_10000'));
        }
        $type = $this->app->request->get('type','string', 'default');
        $form = $this->app->request->get('form', 'string');
        $this->app->document->setMimeEncoding('application/pdf');
        $pdf = $this->app->pdf->create($form, $type);
        
        $pdf->setData($order)->generate()->toBrowser();
    }

    public function notify() {
        $CR = $this->app->cashregister->start();

        $CR->sendNotificationEmail(6371, 'invoice');
        $CR->sendNotificationEmail(6371, 'payment');
    }

    public function home() {
        $this->setRedirect('/');
    }

    public function save() {

        $order = $this->CR->order;
        $next = $this->app->request->get('next','word', 'customer');
        $post = $this->app->request->get('post:', 'array', array());
        //var_dump($order);
        //return;
        $order->elements->remove('items.');
        $order->addItems($this->app->cart->getAll());
        if(isset($post['elements'])) {
            foreach($post['elements'] as $key => $value) {
                if (is_array($value)) {
                    $order->elements->set($key.'.', $value);
                } else {
                    $order->elements->set($key, $value);
                }
            }
        }

        if(isset($post['creditcard'])) {
            $order->params->set('payment.creditcard.', $post['creditcard']);
        }
        
        
        if(isset($post['params'])) {
            foreach($post['params'] as $key => $value) {
                if (is_array($value)) {
                    $order->params->set($key.'.', $value);
                } else {
                    $order->params->set($key, $value);
                }
            }
        }
        $order->save();
        $this->app->session->set('orderID',$order->id,'checkout');

        $this->setRedirect($this->baseurl.'&task='.$next);

    }

    public function orderNotification() {
        $oid = $this->app->request->get('oid', 'int');
        $order = $this->app->orderdev->get($oid);
        $types = array('receipt', 'printer', 'payment');
        $this->app->document->setMimeEncoding('application/json');
        if(!$order->notify()) {
            $mail['status'] = 'Already Sent.';
            echo json_encode($result);
            return;
        }
        // Send the Notifications.
        foreach($types as $type) {
            $order->params->remove('notifications.'.$type.'.');
            $notify = $this->app->notify->create($type, $order);
            $notify->assemble();
            $result = $notify->send();
            if($result !== true) {
                $mail['status.'.$type] = 'Failed: '.$result->__toString();
                $order->params->set('notifications.'.$type.'.error', $result->__toString());
                $order->params->set('notifications.'.$type.'.status', 'failed');
            } else {
                $mail['status.'.$type] = 'success';
                $order->params->set('notifications.'.$type.'.status', 'success');
            }
            
            
            
        }
        $order->save();
        //var_dump($mail);
        echo json_encode($mail);

    }




}