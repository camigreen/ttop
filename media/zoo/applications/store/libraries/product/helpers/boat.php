<?php defined('_JEXEC') or die('Restricted access');

/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

/**
 * Class Description
 *
 * @package Class Package
 */
class BoatHelper extends AppHelper {

	/**
	 * @var [array]
	 */
	protected $_products = array();	
	

	public function __construct($app) {
		parent::__construct($app);

		// load classes
		$this->app->loader->register('AppData', 'classes:data.php');
		$this->app->loader->register('Boat','classes:boat.php');
        $this->app->loader->register('Manufacturer','classes:manufacturer.php');

		$this->xml = simplexml_load_file($this->app->path->path('library.product:items.xml'));
	}

	public function create($make, $model = null) {
        $boat = new Manufacturer($this->app);
        $boat->bind($this->getBoatMake($make));
        if($model) {
            $boat->setParam('choosenModel', $model);
        }
        
        return $boat;

	}

	protected function getBoatMake($make) {
        $xml = $this->xml;
        $make = str_replace('_', '-', $make);
        $boat = $this->app->data->create();
        foreach($xml->boats->boat as $item) {
            if($item->name != $make) {
                continue;
            }
            $params = $this->app->parameter->create();
            // Set Name
            $boat->set('name', (string) $item->name);
            $name = (string) $item->name;
            // Set skucode
            $boat->set('skucode', (string) $item->skucode);
            // Set label
            $boat->set('label', (string) $item->label);

            $boat->set('models', $this->getBoatModels($item));

            foreach($item->attributes() as $param => $value) {
                $params->set($param, (string) $value);
            }
            if(file_exists($this->app->path->path('images.boats:/'.$name.'/ccbc/thumbs/'.$name.'.png'))) {
                $params->set('images.thumb', $this->app->path->url('images.boats:/'.$name.'/ccbc/thumbs/'.$name.'.png'));
            } else {
                $params->set('images.thumb', $this->app->path->url('images.boats:/PNA/thumbs/PNA.png'));
            }
            if(file_exists($this->app->path->path('images.boats:/'.$name.'/ccbc/'.$name.'.png'))) {
                $params->set('images.full', $this->app->path->url('images.boats:/'.$name.'/ccbc/'.$name.'.png'));
            } else {
                $params->set('images.full', $this->app->path->url('images.boats:/PNA/PNA.png'));
            }
            if(file_exists($this->app->path->path('images.logos:/'.$name.'.png'))) {
                $params->set('images.logo', $this->app->path->url('images.logos:/'.$name.'.png'));
            }
            $boat->set('params', $params);
        }
        return $boat;

    }
    protected function getBoatModels($xml) {

        if($xml) {
            $models = $this->app->data->create();
            foreach($xml->models->model as $xModel) {
                $model = $this->app->data->create();
                foreach($xModel as $key => $value) {
                    if($key == 'name') {
                        $name = (string) $value;
                    }
                    $model->set($key, (string) $value);
                }
                $params = $this->app->parameter->create();
                foreach($xModel->attributes() as $param => $value) {
                    $params->set($key, (string) $value);
                }
                $model->set('params', $params);
                $models->set($name, $model);

            }
            return $models;
        }

    }

}

?>