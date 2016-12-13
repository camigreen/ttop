<?php
/**
* @package   
* @author    Shawn Gibbons
* @copyright Copyright (C) Shawn Gibbons
* @license   
*/

class PaymentNotification extends Notification {


	public function assemble() {
		$order = $this->_object;
		$account = $this->app->account->get($order->account);
		$formType = $account->isReseller() ? 'reseller' : 'default';

		// Set Recipients
		$recipients = explode("\n", $this->app->store->get()->params->get('notify_emails'));

		$this->addRecipients($recipients);

		// Set the Subject
		if($this->isTestMode())
			$subject[] = 'Test Mode -';

		$subject[] = 'Online Order Notification - Order# '.$order->id;
		$this->setSubject(implode(' ', $subject));
		
		// Set Attachment
		$pdf = $this->app->pdf->create('workorder', $formType);
        $filename = $pdf->setData($order)->generate()->toFile();
        $attachments = array();
        $attachments[] = array(
        	'path' => $this->app->path->path('assets:pdfs/'.$filename),
        	'name' => 'Order-'.$order->id.'.pdf'
        );
        $this->addAttachment($attachments);

        $this->register('allowEmpty', true);
        // Set Body
		
		return $this;

	}

}