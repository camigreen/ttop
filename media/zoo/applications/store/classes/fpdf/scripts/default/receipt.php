
<?php 

class ReceiptFormPDF extends FormPDF {

	/**
	 * @var [string]
	 */
	public $resource = 'default';

	/**
	 * @var [string]
	 */
	public $type = 'receipt';

	public function setData($order) {
		$form_data = $this->app->data->create();
		$billto = array(
            $order->elements->get('billing.name'),
            $order->elements->get('billing.street1'),
            ($order->elements->get('billing.street2') ? $order->elements->get('billing.street2') : null),
            $order->elements->get('billing.city').', '.$order->elements->get('billing.state').' '.$order->elements->get('billing.postalCode'),
            $order->elements->get('billing.phoneNumber').'  '.$order->elements->get('billing.altNumber'),
            $order->elements->get('email')
        );

		$form_data->set('billto', $billto);
		
		if($order->elements->get('shipping_method') != 'LP') {
        	$shipto = array(
	            $order->elements->get('shipping.name'),
	            $order->elements->get('shipping.street1'),
	            $order->elements->get('shipping.street2'),
	            $order->elements->get('shipping.city').', '.$order->elements->get('shipping.state').' '.$order->elements->get('shipping.postalCode'),
	            $order->elements->get('shipping.phoneNumber').' '.$order->elements->get('shipping.altNumber')
        	);
        	$form_data->set('shipto', $shipto);
    	}
    	$item_array = array();
	    foreach($order->elements->get('items.', array()) as $item) {
	    	$options = array();
	    	foreach($item->getOptions() as $option) {
	    		if($option->get('visible', 'true') == 'true') {
	    			$options[] = $option->get('label').': '.$option->get('text');
	    		}
	    		
	    	}
	    	$item_array[] = array(
	    		'item_description' => array(
	    			array('format' => 'item-name','text' => $item->name),
	    			array('format' => 'item-options','text' => implode("\n",$options))
	    		),
	    		'qty' => array('text' => $item->getQty()),
	    		'price' => array('text' => $item->getTotalPrice())
	    	);

	    }

	    $form_data->set('items', $item_array);
	    $form_data->set('id', $order->id);
	    $form_data->set('created', JHtml::date($order->created, JText::_('DATE_STORE_RECEIPT')));
	    $form_data->set('salesperson', $order->getCreator());
	    $form_data->set('payment_info', $order->params->get('payment.creditcard.card_name').' '.$order->params->get('payment.creditcard.cardNumber'));
	    $form_data->set('delivery_method', JText::_(($ship = $order->elements->get('shipping_method')) ? 'SHIPPING_METHOD_'.$ship : ''));
	    $form_data->set('terms', JText::_(($terms = $order->params->get('terms')) ? 'ACCOUNT_TERMS_'.$terms : ''));

	    $form_data->set('subtotal', $order->getSubtotal());
	    $form_data->set('tax_total', $this->app->number->currency($order->getTaxTotal(), array('currency', 'USD')));
	    $form_data->set('ship_total', $order->getShipTotal());
	    $form_data->set('total', $order->getTotal());

		return parent::setData($form_data);
	}
	
}

?>