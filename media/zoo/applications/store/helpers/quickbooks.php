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
class QuickbooksHelper extends AppHelper {

	//public $dsn = 'mysqli://root:root@localhost/quickbooks';
	public $dsn = 'mysqli://ttopcove_admin:dXX0@wWCn6l!@localhost/ttopcove_qb'; 

	public function __construct($app) {
		parent::__construct($app);
		$path = $this->app->path->path('vendor:');
        $this->app->path->register($path.'/consolibyte/quickbooks', 'quickbooks');
        require_once $this->app->path->path('quickbooks:QuickBooks.php');
        $this->init();
        if (!QuickBooks_Utilities::initialized($this->dsn))
		{
			// Initialize creates the neccessary database schema for queueing up requests and logging
			QuickBooks_Utilities::initialize($this->dsn);
			
			// This creates a username and password which is used by the Web Connector to authenticate
			QuickBooks_Utilities::createUser($this->dsn, QB_QUICKBOOKS_USER, QB_QUICKBOOKS_PWD);

			// Create our test table
			mysqli_query("CREATE TABLE my_customer_table (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  name varchar(64) NOT NULL,
			  fname varchar(64) NOT NULL,
			  lname varchar(64) NOT NULL,
			  quickbooks_listid varchar(255) DEFAULT NULL,
			  quickbooks_editsequence varchar(255) DEFAULT NULL,
			  quickbooks_errnum varchar(255) DEFAULT NULL,
			  quickbooks_errmsg varchar(255) DEFAULT NULL,
			  PRIMARY KEY (id)
			) ENGINE=MyISAM");
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
	public function init() {
		
		define('QB_QUICKBOOKS_PWD', 'password');
		define('QB_QUICKBOOKS_USER', 'quickbooks');
		/**
		 * Configuration parameter for the quickbooks_config table, used to keep track of the last time the QuickBooks sync ran
		 */
		define('QB_QUICKBOOKS_CONFIG_LAST', 'last');

		/**
		 * Configuration parameter for the quickbooks_config table, used to keep track of the timestamp for the current iterator
		 */
		define('QB_QUICKBOOKS_CONFIG_CURR', 'curr');

		/**
		 * Maximum number of customers/invoices returned at a time when doing the import
		 */
		define('QB_QUICKBOOKS_MAX_RETURNED', 10);

		/**
		 * 
		 */
		define('QB_PRIORITY_PURCHASEORDER', 4);

		/**
		 * Request priorities, items sync first
		 */
		define('QB_PRIORITY_ITEM', 3);

		/**
		 * Request priorities, customers
		 */
		define('QB_PRIORITY_CUSTOMER', 2);

		/**
		 * Request priorities, salesorders
		 */
		define('QB_PRIORITY_SALESORDER', 1);

		/**
		 * Request priorities, invoices last... 
		 */
		define('QB_PRIORITY_INVOICE', 0);

		/**
		 * Send error notices to this e-mail address
		 */
		define('QB_QUICKBOOKS_MAILTO', 'shawn@ttopcovers.com');

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
	public function start() {
		$name = $this->app->database->name;
		require_once $this->app->path->path('quickbooks:/docs/web_connector/example_app_web_connector/functions.php');
		// Map QuickBooks actions to handler functions
		$map = array(
			QUICKBOOKS_MOD_INVENTORYASSEMBLYITEM => array( array($this, '_quickbooks_iteminventoryassembly_mod_request'), array($this, '_quickbooks_iteminventoryassembly_mod_response' )),
			QUICKBOOKS_ADD_INVENTORYASSEMBLYITEM => array( '_quickbooks_iteminventoryassembly_add_request', '_quickbooks_iteminventoryassembly_add_response' ),
			QUICKBOOKS_IMPORT_INVENTORYASSEMBLYITEM => array(array($this, '_quickbooks_iteminventoryassembly_import_request'), array($this, '_quickbooks_iteminventoryassembly_import_response' ))
			);

		// This is entirely optional, use it to trigger actions when an error is returned by QuickBooks
		$errmap = array(
			'*' => '_quickbooks_error_catchall', 				// Using a key value of '*' will catch any errors which were not caught by another error handler
			);

		// An array of callback hooks
		$hooks = array(
			);

		// Logging level
		$log_level = QUICKBOOKS_LOG_DEVELOP;		// Use this level until you're sure everything works!!!

		// What SOAP server you're using 
		$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)

		$soap_options = array(		// See http://www.php.net/soap
			);

		$handler_options = array(
			'deny_concurrent_logins' => false, 
			'deny_reallyfast_logins' => false, 
			);		// See the comments in the QuickBooks/Server/Handlers.php file

		$driver_options = array(		// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
			);

		$callback_options = array(
			//'only_import' => array(QUICKBOOKS_IMPORT_INVENTORYITEM)
			);

		// Create a new server and tell it to handle the requests
		// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
		$Server = new QuickBooks_WebConnector_Server($this->dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
		$response = $Server->handle(true, true);
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
	public function queue() {

		return new QuickBooks_WebConnector_Queue($this->dsn);
		
	}

    
}