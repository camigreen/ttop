<?php
/**
* @package   
* @author    Shawn Gibbons
* @copyright Copyright (C) Shawn Gibbons
* @license   
*/

class Notification {

	protected $_storage;

	protected $_object;

	protected $_mail;

	public $app;

	public function __construct($app, $object = null) {
		$this->app = $app;
		$this->_storage = $this->app->parameter->create();
		$this->setObject($object);
		$this->_mail = JFactory::getMailer();
		$this->application = $this->app->zoo->getApplication();
		$this->_mail->SMTPDebug = 4;
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
	protected function register($name, $value) {
		$this->_storage->set($name, $value);
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
	public function get($name, $default = null) {
		return $this->_storage->get($name, $default);
	}

	/**
	 * Add the object of the notification
	 *
	 * @param 	object		Class object that contains the data reference for the notification.
	 *
	 * @return 	Notify Object	Return $this for chaining.
	 *
	 * @since 1.0
	 */
	public function setObject($object) {
		$this->_object = $object;
		return $this;
	}

	/**
	 * Set the method
	 *
	 * @param 	string		The method to call.
	 *
	 * @return 	Notification Object 	Returns $this to support chaining.
	 *
	 * @since 1.0
	 */
	public function setMethod($method) {
		$this->register('method', '_'.$method);
		return $this;
	}

	/**
	 * Is the site in test mode
	 *
	 * @return 	boolean 	True or false if the site is in test mode.
	 *
	 * @since 1.0
	 */
	public function isTestMode() {
		return false;
		return (bool) $this->app->store->merchantTestMode();
	}

	/**
	 * Sets the body of the email
	 *
	 * When setting the body, checks if the string passed is an html page
	 * and set isHTML to true if so.
	 * 
	 * @param string $content The content of the body
	 * 
	 * @since 1.0.0
	 */
	public function setBody($content) {

		// auto-detect html
		if (stripos($content, '<html') !== false) {
			$this->register('isHtml', true);
		}

		// set body
		$this->register('body', $content);
	}

	/**
	 * Set the mail body using a template file
	 * 
	 * @param string $template The path to a template file. Can be use the registered paths
	 * @param array $args The list of arguments to pass on to the template
	 * 
	 * @since 1.0.0
	 */
	public function setBodyFromTemplate($template, $args = array()) {

		// init vars
		$__tmpl = $this->app->path->path($template);

		// does the template file exists ?
		if ($__tmpl == false) {
			throw new Exception("Mail Template $template not found");
		}

		// render the mail template
		extract($args);
		ob_start();
		include($__tmpl);
		$output = ob_get_contents();
		ob_end_clean();

		// set body
		$this->setBody($output);
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
	public function setSubject($subject) {
		$this->register('subject', $subject);
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
	public function addAttachment($attachment) {
		$this->register('attachments.', $attachment);
		return $this;
		
	}

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0 atkub24opir26@hpeprint.com
	 */
	public function addRecipients($recipients = array()) {
		if($this->isTestMode()) {
			//$this->register('recipients.', array('atkub24opir26@hpeprint.com'));
			//$this->register('recipients.', array('sgibbons@palmettoimages.com'));
			$this->register('recipients.', array('shawn@ttopcovers.com'));
			//$this->register('recipients.', array('sales@ttopcovers.com'));
		} else {
			var_dump($recipients);
			$recipients = array_merge($this->get('recipients.', array()), $recipients);
			$this->register('recipients.', $recipients);
		}
		return $this;
	}

	/**
	 * Send the notifications.
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	boolean 	Result of the send.
	 *
	 * @since 1.0
	 */
	public function send() {

			// Reply To
			$this->_mail->addReplyTo($this->get('replyTo'));

			// Allow Empty
			$this->_mail->AllowEmpty = $this->get('allowEmpty', false);

			// Sender
			$config = JFactory::getConfig();
				$sender = array( 
				    $config->get( 'mailfrom' ),
				    $config->get( 'fromname' ) 
				);
			$this->_mail->setSender($this->get('from.', $config->get('mailfrom')));

			// Subject
			$this->_mail->setSubject($this->get('subject', 'A Message from LaPorte\'s Products'));

			// Body
			$this->_mail->setBody($this->get('body'));
			$this->_mail->isHTML($this->get('isHtml', false));

			// Recipients
			foreach($this->get('recipients.', array()) as $recipient) {
				$this->_mail->addRecipient($recipient);
			}

			// Attachments
			foreach($this->get('attachments.', array()) as $attachment) {
			 	$this->_mail->addAttachment($attachment['path'], $attachment['name']);
			}
			
			//  Send it
			//$this->_mail->useSmtp();
			$send = $this->_mail->Send();

			return $send;
			


		foreach($this->get('attachments.', array()) as $attachment) {
			unlink($attachment['path']);
		}
	}

}