<?php 
use SimpleUPS\UPS;

/* @var string UPS_ACCESSLICENSENUMBER The UPS license number to be used in API requests */
define('UPS_ACCESSLICENSENUMBER', 'CCE85AD5154DDC46');

/* @var string UPS_ACCOUNTNUMBER The UPS account number to use in API requests */
define('UPS_ACCOUNTNUMBER', '');

/* @var string UPS_USERID The UPS user ID when logging into UPS.com */
define('UPS_USERID', 'ttopboatcovers');

/* @var string UPS_PASSWORD The UPS password when logging into UPS.com */
define('UPS_PASSWORD', 'admin2');

/* @var bool UPS_DEBUG The debug mode for this library */
define('UPS_DEBUG', FALSE);

/* @var bool UPS_CURRENCY_CODE Currency code to use for rates */
define('UPS_CURRENCY_CODE', 'USD');

 
/**
 * ----- SHIPPER DETAILS -----
 */

/* @var string UPS_SHIPPER_NUMBER */
define('UPS_SHIPPER_NUMBER', '01WV66');

/* @var string UPS_SHIPPER_ADDRESSEE Name of the company or addressee */
define('UPS_SHIPPER_ADDRESSEE', 'Laportes T-Top Boat Covers');

/* @var string UPS_SHIPPER_STREET Shipper street */
define('UPS_SHIPPER_STREET', '4651 Franchise Street');
// define('UPS_SHIPPER_STREET', '1123 Jerusalem Ave');

/* @var string UPS_SHIPPER_ADDRESS_LINE2 Additional address information, preferably room or floor */
define('UPS_SHIPPER_ADDRESS_LINE2', '');

/* @var string UPS_SHIPPER_ADDRESS_LINE3 Additional address information, preferably department name */
define('UPS_SHIPPER_ADDRESS_LINE3', '');

/* @var string UPS_SHIPPER_CITY Shipper city */
define('UPS_SHIPPER_CITY', 'North Charleston');
// define('UPS_SHIPPER_CITY', 'Uniondale');

/* @var string UPS_SHIPPER_STATEPROVINCE_CODE Shipper state or province */
define('UPS_SHIPPER_STATEPROVINCE_CODE', 'SC');
// define('UPS_SHIPPER_STATEPROVINCE_CODE', 'NY');

/* @var string UPS_SHIPPER_POSTAL_CODE Shipper postal code */
define('UPS_SHIPPER_POSTAL_CODE', '29418');
// define('UPS_SHIPPER_POSTAL_CODE', '11553');

/* @var string UPS_SHIPPER_COUNTRY_CODE Shipper country code */
define('UPS_SHIPPER_COUNTRY_CODE', 'US');

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
class ShipperHelper extends AppHelper {

    public $destination;
    protected $shipper;
    public $packages = array();
    public $packageWeightMax = 50;
    public $packageInsuredValuePercentage = .30;
    protected $availableShipMethods = array('03');
    protected $_rates;
    protected $_errors = array();
    public $shipment;

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function __construct($app) {
        parent::__construct($app);

        $this->shipment = new \SimpleUPS\Rates\Shipment();
    }


    public function setDestination($address) {

        $destination = $this->createAddress($address);

        if(!$this->validateAddress($destination)) {
            return;
        }

        $this->destination = new \SimpleUPS\InstructionalAddress($destination);
        $this->destination->setAddressee($address->get('name'));
        $this->destination->setAddressLine2($address->get('street2', null));
        $this->destination->setAddressLine3($address->get('street3', null));

        $this->shipment->setDestination($this->destination);

        return $this;
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
    public function createAddress($address) {
        if(!$address instanceof ArrayObject) {
            $address = $this->app->data->create($address);
        }
        $a = new \SimpleUPS\Address();
        $a->setStreet($address->get('street1'));
        $a->setCity($address->get('city'));
        $a->setStateProvinceCode($address->get('state'));
        $a->setPostalCode($address->get('postalCode'));
        $a->setPostalCodeExtended($address->get('postalCodeExtended'));
        $a->setCountryCode($address->get('countryCode', 'US'));

        return $a;

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
    public function createInstructionalAddress(\SimpleUPS\Address $address) {
        $instructionalAddress = new \SimpleUPS\InstructionalAddress($destination);
        $instructionalAddress->setAddressee($address->get('name'));
        $instructionalAddress->setAddressLine2($address->get('street2', null));
        $instructionalAddress->setAddressLine3($address->get('street3', null));
    }

    public function setShipper() {
        $address = new \SimpleUPS\InstructionalAddress();
        $address->setAddressee(UPS_SHIPPER_ADDRESSEE);
        $address->setAddressline2(UPS_SHIPPER_ADDRESS_LINE2);
        $address->setAddressline3(UPS_SHIPPER_ADDRESS_LINE3);
        $address->setCity(UPS_SHIPPER_CITY);
        $address->setStateProvinceCode(UPS_SHIPPER_STATEPROVINCE_CODE);
        $address->setPostalCode(UPS_SHIPPER_POSTAL_CODE);
        $address->setCountryCode(UPS_SHIPPER_COUNTRY_CODE);

        $shipper = new \SimpleUPS\Shipper();
        $shipper->setAddress($address);
        $shipper->setNumber(UPS_SHIPPER_NUMBER);

        $this->shipment->setShipper($shipper);

        return $this;

    }

    public function getShipper() {
        return $this->shipper;
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
    public function hasErrors() {
        return !empty($this->_errors);
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
    public function getErrors() {
        return $this->_errors;
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
    protected function setError($error) {
        $this->_errors[] = $error;
    }

    public function validateAddress(\SimpleUPS\Address $address) {

        // try {
        //     $valid = UPS::isValidRegion($address);
        // } catch (Exception $e) {
        //     $this->setError($e->getMessage());
        //     //throw new ShipperException($e->getCode());
        // } 

        // if(!$valid) {
        //     throw new ShipperException('003');
        // }
        
        try {
            $valid = UPS::isValidAddress($address);

        } catch (Exception $e) {
            throw new ShipperException($e->getMessage(), 1002);
        } 

        if(!$valid) {
            $this->setError(JText::_('SHIPPER_ERROR_002'));
        }

        return $valid;
        

        // $this->destination = new \SimpleUPS\InstructionalAddress($destination);
        
        // $this->destination->setAddressee($address->get('name'));
        // $this->destination->setAddressLine2($address->get('street2', null));
        // $this->destination->setAddressLine3($address->get('street3', null));
        // $this->destination->validated = true;
        // return $this->destination;

    }

    public function assemblePackages ($items) {
        $this->packages = array();
        $newpackage = $this->app->parameter->create();
        $count = 1;
        foreach($items as $item) {
            $shipWeight = $item->getWeight();
            if($shipWeight == 0) {
                throw new ShipperException('001'); 
            }
            $qty = $item->getQty();
            while($qty >= 1) {
                if(($newpackage->get('weight', 0) + $shipWeight) > $this->packageWeightMax) {
                    $package = new \SimpleUPS\Rates\Package();
                    $package->setWeight($newpackage->get('weight'))->setDeclaredValue($newpackage->get('insurance'), 'USD');
                    $this->packages[] = $package;
                    $newpackage = $this->app->parameter->create();
                    $count = 1;
                }
                $newpackage->set('weight', $newpackage->get('weight', 0) + $shipWeight);
                $newpackage->set('insurance', $newpackage->get('insurance', 0.00) + $item->getPrice()*$this->packageInsuredValuePercentage);
                $count++;
                $qty--;
            }
        }
        $package = new \SimpleUPS\Rates\Package();
        $package->setWeight(0)->setDeclaredValue($newpackage->get('insurance'), 'USD');
        $package->setWeight($newpackage->get('weight'))->setDeclaredValue($newpackage->get('insurance'), 'USD');
        $this->packages[] = $package;

        return $this;
    }

    public function getRates($order) {
        if($this->_rates) {

            return $this->_rates;
        }
        
        try {
            // set the destination 
            if(!$this->setDestination($order->getShipping())) {
                return;
            }

            // assemble the packages

            $this->assemblePackages ($order->elements->get('items.'));

            //create the shipment            
                foreach($this->packages as $package) {
                    $this->shipment->addPackage($package);
                }
                $this->setShipper();

            //get the rates

            $rates = UPS::getRates($this->shipment);

        } catch (ShipperException $e) {
            $this->setError($e->getMessage());
           return;
        }
        if (UPS::getDebug()) {
            UPS::getDebugOutput();
        }
        foreach ($rates as $shippingMethod) {
            $this->_rates[$shippingMethod->getService()->getCode()] = $shippingMethod;
        }
        return $this->_rates;
    }

    public function getRateByMethod($method) {
        if(empty($this->_rates)) {
            $this->getRates();
        }
        if(isset($this->_rates[$method])) {
            return $this->_rates[$method]->getTotalCharges();
        }

        return 'Sevice Method Not Found.';

    }

    public function getPostalCodes($code) {

        $pc = new \SimpleUPS\PostalCodes();
        return $pc->get($code);

    }

    public function getAvailableShippingMethods() {
        $method = new \SimpleUPS\Service();
        $method->setCode('LP')->setDescription('Local Pickup - FREE');
        $methods[] = $method;
        foreach($this->availableShipMethods as $shipMethod) {
            $method = new \SimpleUPS\Service();
            $method->setCode($shipMethod);
            $description = $method->getDescription();
            $description = 'UPS - '. $description;
            $method->setDescription($description);
            $methods[] = $method;
        }

        return $methods;
 
    }

    
}

/**
 * The library was successfully able to communicate with the UPS API, and the
 * API determined that the authentication information provided is invalid.
 * @see   \SimpleUPS\UPS::setAuthentication()
 * @since 1.0
 */
class ShipperException extends Exception {


    public function __construct($message = null, $code = 0, Exception $previous = null) {
        if(is_int($message)) {
            $message = JText::_('SHIPPER_ERROR_'.$message);
            $code = (int) $message;
        }
        
        parent::__construct($message, $code, $previous);
    }
}