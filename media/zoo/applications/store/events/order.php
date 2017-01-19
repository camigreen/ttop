<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/**
 * Deals with application events.
 *
 * @package Component.Events
 */
class OrderEvent {

	/**
	 * When an application is loaded on the frontend,
	 * load the language files from the app folder too
	 *
	 * @param  AppEvent 	$event The event triggered
	 */
	public static function init($event) {

		$order = $event->getSubject();
        $app         = $order->app;

        $order->table = $app->table->orderdev;
        $order->params = $app->parameter->create($order->params);
        $order->elements = $app->parameter->create($order->elements);

    	if(!$order->isProcessed()) {
    		$_items = array();
        	foreach($order->getItems() as $item) {
        		$item = $app->product->create($item);
        		$_items[$item->getHash()] = $item;	
        	}
        	$order->elements->remove('items.');
        	$order->elements->set('items.', $_items);
        } else {
        	$items = $order->elements->get('items.', array());
	    	foreach($items as $key => $item) {
	    		try { 
					$item = $app->product->create($item);
		      		$order->elements->set('items.'.$key, $item);
	    		} catch (Exception $e) {
					echo 'Error - Order ID: '.$order->id.'</br>';
		        	echo $e->getMessage();
		        	unset($item['price']);
		        	$item = $app->product->create($item);
		        	$order->elements->set('items.'.$key, $item);
	    		}
		    	
		    }
        }

        // $order->getTotal();
	}

	/**
	 * Placeholder for the saved event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function saved($event) {

		$order = $event->getSubject();
		$new = $event['new'];

	}

	/**
	 * Placeholder for the deleted event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function deleted($event) {

		$order = $event->getSubject();

	}

	/**
	 * Placeholder for the installed event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function installed($event) {

		$order = $event->getSubject();
		$update = $event['update'];

	}

	/**
	 * Placeholder for the addmenuitems event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function addmenuitems($event) {

		$order = $event->getSubject();

		// Tab object
		$tab = $event['tab'];

		// add child

		// return the tab object
		$event['tab'] = $tab;
	}

	/**
	 * Placeholder for the statusChanged event
	 *
	 * @param  AppEvent $event The event triggered
	 */

	public static function statusChanged($event) {

		$item = $event->getSubject();
		$old_status = $event['old_status'];

	}

	/**
	 * Placeholder for the deleted event
	 *
	 * @param  AppEvent $event The event triggered
	 */
	public static function paymentFailed($event) {

		$order = $event->getSubject();
		$response = $event['response'];
		$app = $order->app;
		$app->log->createLogger('email',array('shawn@ttopcovers.com'));
		foreach ($response as $key => $value) {
			if ($key == 'response') {
				continue;
			}
				$value = is_bool($value) ? ($value ? 'True' : 'False') : $value;
				$data[] = $key.': '.$value;
		}
		foreach ($order->elements->get('items.', array()) as $key => $value) {
				$data[] = $value->name."\n";
		}
		$message = implode("\n", $data);
        $app->log->notice($message,'Process Payment Failed');


	}


}