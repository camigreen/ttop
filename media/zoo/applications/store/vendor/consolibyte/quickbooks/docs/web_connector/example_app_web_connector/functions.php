<?php

/**
 * Example Web Connector application
 * 
 * This is a very simple application that allows someone to enter a customer 
 * name into a web form, and then adds the customer to QuickBooks.
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */


/**
 * Get the last date/time the QuickBooks sync ran
 * 
 * @param string $user		The web connector username 
 * @return string			A date/time in this format: "yyyy-mm-dd hh:ii:ss"
 */
function _quickbooks_get_last_run($user, $action, $dsn)
{
	$type = null;
	$opts = null;
	return QuickBooks_Utilities::configRead($dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_LAST . '-' . $action, $type, $opts);
}

/**
 * Set the last date/time the QuickBooks sync ran to NOW
 * 
 * @param string $user
 * @return boolean
 */
function _quickbooks_set_last_run($user, $action, $dsn, $force = null)
{
	$value = date('Y-m-d') . 'T' . date('H:i:s');
	
	if ($force)
	{
		$value = date('Y-m-d', strtotime($force)) . 'T' . date('H:i:s', strtotime($force));
	}
	
	return QuickBooks_Utilities::configWrite($dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_LAST . '-' . $action, $value);
}

/**
 * 
 * 
 */
function _quickbooks_get_current_run($user, $action, $dsn)
{
	$type = null;
	$opts = null;
	return QuickBooks_Utilities::configRead($dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_CURR . '-' . $action, $type, $opts);	
}

/**
 * 
 * 
 */
function _quickbooks_set_current_run($user, $action, $dsn,   $force = null)
{
	$value = date('Y-m-d') . 'T' . date('H:i:s');
	
	if ($force)
	{
		$value = date('Y-m-d', strtotime($force)) . 'T' . date('H:i:s', strtotime($force));
	}
	
	return QuickBooks_Utilities::configWrite($dsn, $user, md5(__FILE__), QB_QUICKBOOKS_CONFIG_CURR . '-' . $action, $value);	
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

	$xml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="13.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="stopOnError">
			<ItemInventoryAssemblyModRq>
				<ItemInventoryAssemblyMod>
					<ListID></ListID>
				</ItemInventoryAssemblyMod>
			</ItemInventoryAssemblyModRq>
		</QBXMLMsgsRq>
	</QBXML>';
	
	return $xml;
}

/**
 * Receive a response from QuickBooks 
 */
function _quickbooks_iteminventoryassembly_mod_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	

}

/**
 * Build a request to import customers already in QuickBooks into our application
 */
function _quickbooks_iteminventoryassembly_import_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$dsn = $extra['dsn'];
	// Iterator support (break the result set into small chunks)
	QuickBooks_Utilities::log($dsn, 'Started Item Inventory Assembly Import ');
	$attr_iteratorID = '';
	$attr_iterator = ' iterator="Start" ';
	if (empty($extra['iteratorID']))
	{
		// This is the first request in a new batch
		$last = _quickbooks_get_last_run($user, $action, $dsn);
		_quickbooks_set_last_run($user, $action, $dsn);			// Update the last run time to NOW()
		
		// Set the current run to $last
		_quickbooks_set_current_run($user, $action, $last, $dsn);
	}
	else
	{
		// This is a continuation of a batch
		$attr_iteratorID = ' iteratorID="' . $extra['iteratorID'] . '" ';
		$attr_iterator = ' iterator="Continue" ';
		
		$last = _quickbooks_get_current_run($user, $action, $dsn);
	}
	QuickBooks_Utilities::log($dsn, 'asdfasdfmbly Import ');
	// Build the request
	$xml = '<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="' . $version . '"?>
		<QBXML>
			<QBXMLMsgsRq onError="stopOnError">
				<ItemInventoryQueryRq ' . $attr_iterator . ' ' . $attr_iteratorID . ' requestID="' . $requestID . '">
					<MaxReturned>' . QB_QUICKBOOKS_MAX_RETURNED . '</MaxReturned>
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
	// QuickBooks_Utilities::log($dsn, 'Item Inventory Response');
	// $app = $extra['app'];
	// if (!empty($idents['iteratorRemainingCount']))
	// {
	// 	// Queue up another request
		
	// 	//$Queue = QuickBooks_WebConnector_Queue_Singleton::getInstance();
	// 	//$Queue->enqueue(QUICKBOOKS_IMPORT_ITEMINVENTORYASSEMBLY, null, QB_PRIORITY_ITEMINVENTORYASSEMBLY, array( 'iteratorID' => $idents['iteratorID'] ));
	// }
	
	// // This piece of the response from QuickBooks is now stored in $xml. You 
	// //	can process the qbXML response in $xml in any way you like. Save it to 
	// //	a file, stuff it in a database, parse it and stuff the records in a 
	// //	database, etc. etc. etc. 
	// //	
	// // The following example shows how to use the built-in XML parser to parse 
	// //	the response and stuff it into a database. 
	
	// // Import all of the records
	// $errnum = 0;
	// $errmsg = '';
	// $Parser = new QuickBooks_XML_Parser($xml);
	// if ($Doc = $Parser->parse($errnum, $errmsg))
	// {
	// 	$Root = $Doc->getRoot();
	// 	$List = $Root->getChildAt('QBXML/QBXMLMsgsRs/ItemInventoryQueryRs');
		
	// 	foreach ($List->children() as $Customer)
	// 	{
	// 		$arr = array(
	// 			'value_1' => $Customer->getChildDataAt('ItemInventoryRet ListID'),
	// 			'value_2' => $Customer->getChildDataAt('ItemInventoryRet FullName'),
	// 			'value_3' => $Customer->getChildDataAt('ItemInventoryRet EditSequence'),
	// 			);
			
	// 		QuickBooks_Utilities::log($dsn, 'Importing Assembly Item ' . $arr['FullName'] . ': ' . print_r($arr, true));
			
	// 		// foreach ($arr as $key => $value)
	// 		// {
	// 		// 	$arr[$key] = $this->database->escape($value);
	// 		// }
	// 		QuickBooks_Utilities::log($dsn, $app->database->name);
	// 		// Store the invoices in MySQL
	// 		$app->database->query("
	// 			INSERT INTO
	// 				qb_test
	// 			(
	// 				" . implode(", ", array_keys($arr)) . "
	// 			) VALUES (
	// 				'" . implode("', '", array_values($arr)) . "'
	// 			)") or die(trigger_error(mysql_error()));
	// 	}
	// }
	
	//return true;
}

/**
 * Catch and handle an error from QuickBooks
 */
function _quickbooks_error_catchall($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	
}
