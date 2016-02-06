<?php namespace SimpleUPS\Rates;


/**
 * Default
 * @since 1.0
 */

class Package extends \SimpleUPS\Package
{
    const
        TYPE_UNKNOWN = '00',
        TYPE_UPS_LETTER = '01',
        TYPE_PACKAGE = '02',
        TYPE_TUBE = '03',
        TYPE_PAK = '04',
        TYPE_EXPRESS_BOX = '21',
        TYPE_25KG_BOX = '24',
        TYPE_10KG_BOX = '25',
        TYPE_PALLET = '30',
        TYPE_SMALL_EXPRESS_BOX = '2a',
        TYPE_MEDIUM_EXPRESS_BOX = '2b',
        TYPE_LARGE_EXPRESS_BOX = '2c';

    private
        /* @var string $unitOfMeasurement */
        $unitOfMeasurement = 'IN',

        /* @var string $type */
        $type,
        /* @var float $length */
        $length,

        /* @var float $width */
        $width,

        /* @var float $height */
        $height,

        /* @var float $insuranceAmount */
        $insuranceAmount;

    private static
        $MEASUREMENT_INCHES = 'IN',
        $MEASUREMENT_CENTIMETERS = 'CM';

    public function __construct()
    {
        $this->measurement = self::$MEASUREMENT_INCHES;
    }

    /**
     * Define this package as the dimensions being measured in inches
     */
    public function measuredInCentimeters()
    {
        $this->setUnitOfMeasurement(self::$MEASUREMENT_CENTIMETERS);
    }

    /**
     * @param string $unitOfMeasurement
     *
     * @return Package
     */
    private function setUnitOfMeasurement($unitOfMeasurement)
    {
        $this->unitOfMeasurement = $unitOfMeasurement;
        return $this;
    }

    /**
     * @return string
     */
    private function getUnitOfMeasurement()
    {
        return $this->unitOfMeasurement;
    }

    /**
     * Defines the type of package.  "TYPE_PACKAGE" is default.  Refer to class constants for possible values
     *
     * @param string $type
     *
     * @return Package
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return float
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param float $height
     *
     * @return Package
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $length
     *
     * @return Package
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param float $width
     *
     * @return Package
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @internal
     *
     * @param \DomDocument $dom
     *
     * @return \DOMElement
     * @throw \SimpleUPS\Api\MissingParameterException
     */
    public function toXml(\DomDocument $dom)
    {
        $package = $dom->createElement('Package');

        if ($this->getType() == null) {
            $this->setType(Package::TYPE_PACKAGE);
        }

        $package->appendChild($packagingType = $dom->createElement('PackagingType'));
        $packagingType->appendChild($dom->createElement('Code', $this->getType()));

        if ($this->getLength() != null || $this->getHeight() != null || $this->getWidth() != null) {
            $package->appendChild($dimensions = $dom->createElement('Dimensions'));
            $unitOfMeasurement = $dimensions->appendChild($dom->createElement('UnitOfMeasurement'));
            $unitOfMeasurement->appendChild($dom->createElement('Code', $this->getUnitOfMeasurement()));

            if ($this->getType() != Package::TYPE_UPS_LETTER &&
                $this->getType() != Package::TYPE_TUBE &&
                $this->getType() != Package::TYPE_EXPRESS_BOX
            ) {

                if ($this->getLength() != null) {
                    $dimensions->appendChild($dom->createElement('Length', $this->getLength()));
                }

                if ($this->getHeight() != null) {
                    $dimensions->appendChild($dom->createElement('Height', $this->getHeight()));
                }

                if ($this->getWidth() != null) {
                    $dimensions->appendChild($dom->createElement('Width', $this->getWidth()));
                }
            }
        }

        if ($this->getWeight() != null) {
            $package->appendChild($this->getWeight()->toXml($dom));
        }
        if ($this->getPackageServiceOptions() != null) {
            $package->appendChild($this->getPackageServiceOptions()->toXml($dom));
        }
        return $package;
    }
}