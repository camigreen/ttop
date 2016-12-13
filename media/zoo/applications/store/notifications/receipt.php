<?php
/**
* @package   
* @author    Shawn Gibbons
* @copyright Copyright (C) Shawn Gibbons
* @license   
*/

class ReceiptNotification extends Notification {


	public function assemble() {
		$order = $this->_object;
		$account = $this->app->account->get($order->account);

		// Set Recipients
		if($account->isReseller()) {
			$formType = 'reseller';
			foreach($account->getNotificationEmails() as $email) {
				$recipients[] = $email;
			}
		} else {
			$recipients[] = $order->elements->get('email');
			$formType = 'default';
		}

		$this->addRecipients($recipients);

		// Set the Subject
		$subject = 'Thank you for your order'.($this->isTestMode() ? ' - Test Order# '. $order->id : '');
		$this->setSubject($subject);
		
		// Set Attachment
		$pdf = $this->app->pdf->create('receipt', $formType);
        $filename = $pdf->setData($order)->generate()->toFile();
        $attachments = array();
        $attachments[] = array(
        	'path' => $this->app->path->path('assets:pdfs/'.$filename),
        	'name' => 'Order-'.$order->id.'.pdf'
        );
        $this->addAttachment($attachments);


        // Set Body
		$this->setBodyFromTemplate($this->application->getTemplate()->resource.'mail.checkout.receipt.php');
		return $this;

	}

}