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
	//public $dsn = 'mysqli://ttopcove_admin:dXX0@wWCn6l!@ttopcovers.com/ttopcove_qb'; 

	public $_queue;

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
			$this->app->database->query("CREATE TABLE my_customer_table (
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
			QUICKBOOKS_MOD_INVENTORYASSEMBLYITEM => array(array($this, '_quickbooks_iteminventoryassembly_mod_request'), array($this, '_quickbooks_iteminventoryassembly_mod_response' )),
			QUICKBOOKS_ADD_INVENTORYASSEMBLYITEM => array(array($this, '_quickbooks_iteminventoryassembly_add_request'), array($this, '_quickbooks_iteminventoryassembly_add_response' )),
			QUICKBOOKS_IMPORT_INVENTORYASSEMBLYITEM => array(array($this, '_quickbooks_iteminventoryassembly_import_request'), array($this, '_quickbooks_iteminventoryassembly_import_response' ))
			);

		// This is entirely optional, use it to trigger actions when an error is returned by QuickBooks
		$errmap = array(
			'*' => array($this, '_quickbooks_error_catchall'), 				// Using a key value of '*' will catch any errors which were not caught by another error handler
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
		if(!$this->_queue) {
			$this->_queue = new QuickBooks_WebConnector_Queue($this->dsn);
		}
		
		return $this->_queue;
		
	}

	/**
 * Get the last date/time the QuickBooks sync ran
 * 
 * @param string $user		The web connector username 
 * @return string			A date/time in this format: "yyyy-mm-dd hh:ii:ss"
 */
function _quickbooks_get_last_run($user, $action)
{
	$type = null;
	$opts = null;
	return QuickBooks_Utilities::configRead($this->dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_LAST . '-' . $action, $type, $opts);
}

/**
 * Set the last date/time the QuickBooks sync ran to NOW
 * 
 * @param string $user
 * @return boolean
 */
function _quickbooks_set_last_run($user, $action, $force = null)
{
	$value = date('Y-m-d') . 'T' . date('H:i:s');
	
	if ($force)
	{
		$value = date('Y-m-d', strtotime($force)) . 'T' . date('H:i:s', strtotime($force));
	}
	
	return QuickBooks_Utilities::configWrite($this->dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_LAST . '-' . $action, $value);
}

/**
 * 
 * 
 */
function _quickbooks_get_current_run($user, $action)
{
	$type = null;
	$opts = null;
	return QuickBooks_Utilities::configRead($this->dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_CURR . '-' . $action, $type, $opts);	
}

/**
 * 
 * 
 */
function _quickbooks_set_current_run($user, $action, $force = null)
{
	$value = date('Y-m-d') . 'T' . date('H:i:s');
	
	if ($force)
	{
		$value = date('Y-m-d', strtotime($force)) . 'T' . date('H:i:s', strtotime($force));
	}
	
	return QuickBooks_Utilities::configWrite($this->dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_CURR . '-' . $action, $value);	
}

/**
 * Generate a qbXML response to add a particular customer to QuickBooks
 */
function _quickbooks_iteminventoryassembly_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// Grab the data from our MySQL database
	//$arr = mysqli_fetch_assoc(mysqli_query("SELECT * FROM my_customer_table WHERE id = " . (int) $ID));

	$xml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="13.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="stopOnError">
			<ItemInventoryAssemblyAddRq>
				<ItemInventoryAssemblyAdd>
					<Name>Test Assembly Item</Name>
					<UnitOfMeasureSetRef>
						<FullName >Each</FullName>
					</UnitOfMeasureSetRef>
					<SalesDesc >Test Description (Sales)</SalesDesc>
					<SalesPrice >555.00</SalesPrice>
					<IncomeAccountRef>
						<FullName >Sales</FullName>
					</IncomeAccountRef>
					<PurchaseDesc >Test Description (Purchase)</PurchaseDesc>
					<COGSAccountRef>
						<FullName >Cost of Goods Sold</FullName>
					</COGSAccountRef>
					<AssetAccountRef>
						<FullName >Materials Inventory</FullName>
					</AssetAccountRef>
					<BuildPoint>1</BuildPoint>
				</ItemInventoryAssemblyAdd>
			</ItemInventoryAssemblyAddRq>
		</QBXMLMsgsRq>
	</QBXML>';
	
	return $xml;
}

/**
 * Receive a response from QuickBooks 
 */
function _quickbooks_iteminventoryassembly_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	

}

/**
 * Generate a qbXML response to add a particular customer to QuickBooks
 */
function _quickbooks_iteminventoryassembly_mod_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// Grab the data from our MySQL database
	//$arr = mysqli_fetch_assoc(mysqli_query("SELECT * FROM my_customer_table WHERE id = " . (int) $ID));
	$item = $this->app->table->get('qb_test', '#__')->first(array('conditions' => array("listid = '".$ID."'")));

	$xml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="13.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="stopOnError">
			<ItemInventoryModRq>
				<ItemInventoryMod>
					<ListID>'.$item->listid.'</ListID>
					<EditSequence>'.$item->editsequence.'</EditSequence>
					<Name>'.$item->name.'</Name>
					<SalesDesc>'.$item->salesdesc.'</SalesDesc>
					<PurchaseDesc>'.$item->purchasedesc.'</PurchaseDesc>
				</ItemInventoryMod>
			</ItemInventoryModRq>
		</QBXMLMsgsRq>
	</QBXML>';
	
	return $xml;
}

/**
 * Receive a response from QuickBooks 
 */
function _quickbooks_iteminventoryassembly_mod_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	

	$table = $this->app->table->get('qb_test', '#__');
	$table->key = 'listid';
	$item = $table->first(array('conditions' => array("listid = '".$ID."'")));
	$item->editsequence = $this->app->database->escape($idents['EditSequence']);
	$table->save($item);
	QuickBooks_Utilities::log($this->dsn, print_r($idents, true));
}

	/**
 * Build a request to import customers already in QuickBooks into our application
 */
function _quickbooks_iteminventoryassembly_import_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// Iterator support (break the result set into small chunks)
	QuickBooks_Utilities::log($this->dsn, 'Started Sending Item Inventory Assembly Import Request ');
	$attr_iteratorID = '';
	$attr_iterator = ' iterator="Start" ';
	if (empty($extra['iteratorID']))
	{
		// This is the first request in a new batch
		$last = $this->_quickbooks_get_last_run($user, $action);
		$this->_quickbooks_set_last_run($user, $action);			// Update the last run time to NOW()
		
		// Set the current run to $last
		$this->_quickbooks_set_current_run($user, $action, $last);
	}
	else
	{
		// This is a continuation of a batch
		$attr_iteratorID = ' iteratorID="' . $extra['iteratorID'] . '" ';
		$attr_iterator = ' iterator="Continue" ';
		
		$last = $this->_quickbooks_get_current_run($user, $action);
	}
	// Build the request
	$xml = '<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="' . $version . '"?>
		<QBXML>
			<QBXMLMsgsRq onError="stopOnError">
				<ItemInventoryQueryRq ' . $attr_iterator . ' ' . $attr_iteratorID . ' requestID="' . $requestID . '">
					<MaxReturned>5</MaxReturned>
					<FromModifiedDate>' . $last . '</FromModifiedDate>
					<OwnerID>0</OwnerID>
				</ItemInventoryQueryRq>	
			</QBXMLMsgsRq>
		</QBXML>';
	return $xml;
}

/** 
 * Handle a response from QuickBooks 
 */
function _quickbooks_iteminventoryassembly_import_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	QuickBooks_Utilities::log($this->dsn, 'Item Inventory Response '.print_r($idents,true));
	if (!empty($idents['iteratorRemainingCount']))
	{
		QuickBooks_Utilities::log($this->dsn, 'Starting Queue');
		//Queue up another request
		$this->queue()->enqueue(QUICKBOOKS_IMPORT_INVENTORYASSEMBLYITEM, null, QB_PRIORITY_ITEM, array( 'iteratorID' => $idents['iteratorID'] ));
		
		
	}
	
	// This piece of the response from QuickBooks is now stored in $xml. You 
	//	can process the qbXML response in $xml in any way you like. Save it to 
	//	a file, stuff it in a database, parse it and stuff the records in a 
	//	database, etc. etc. etc. 
	//	
	// The following example shows how to use the built-in XML parser to parse 
	//	the response and stuff it into a database. 
	
	// Import all of the records
	$errnum = 0;
	$errmsg = '';
	$Parser = new QuickBooks_XML_Parser($xml);
	if ($Doc = $Parser->parse($errnum, $errmsg))
	{
		$Root = $Doc->getRoot();
		$List = $Root->getChildAt('QBXML/QBXMLMsgsRs/ItemInventoryQueryRs');
		
		foreach ($List->children() as $Customer)
		{
			$arr = array(
				'listid' => $Customer->getChildDataAt('ItemInventoryRet ListID'),
				'name' => $Customer->getChildDataAt('ItemInventoryRet Name'),
				'editsequence' => $Customer->getChildDataAt('ItemInventoryRet EditSequence'),
				'purchasedesc' => $Customer->getChildDataAt('ItemInventoryRet PurchaseDesc'),
				'salesdesc' => $Customer->getChildDataAt('ItemInventoryRet SalesDesc')
				);
			
			QuickBooks_Utilities::log($this->dsn, 'Importing Assembly Item ' . $arr['name'] . ': ' . print_r($arr, true));
			
			// foreach ($arr as $key => $value)
			// {
			// 	$arr[$key] = $this->database->escape($value);
			// }
			// Store the invoices in MySQL
			$sql = "REPLACE INTO
					joomla_qb_test
				(
					" . implode(", ", array_keys($arr)) . "
				) VALUES (
					'" . implode("', '", array_values($arr)) . "'
				)";
			QuickBooks_Utilities::log($this->dsn, 'SQL = '.$sql);
			$this->app->database->query($sql);
				
		}
	}
	
	return true;
}

/**
 * Catch and handle an error from QuickBooks
 */
function _quickbooks_error_catchall($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	return;
}

    
}