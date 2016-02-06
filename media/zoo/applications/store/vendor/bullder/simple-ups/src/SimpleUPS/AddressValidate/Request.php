<?php namespace SimpleUPS\AddressValidate;

use \SimpleUPS\Api\MissingParameterException;

use \SimpleUPS\UPS;

/**
 * A request/response handler for validating a street address
 * @internal
 * @link https://www.ups.com/upsdeveloperkit/downloadresource?loc=en_US
 */
class Request extends \SimpleUPS\Api\Request
{
    private
        /* @var Address $address */
        $address;

    /**
     * @param null $debug
     */
    public function __construct($debug = null)
    {
        parent::__construct($debug);

        $this->responseClass = false;
    }

    /**
     * Determine which API call will be made
     * @return string
     */
    public function getUrl()
    {
        return $this->getDebug() ? 'https://wwwcie.ups.com/ups.app/xml/XAV' : 'https://onlinetools.ups.com/ups.app/xml/XAV';
    }

    /**
     * Build the validate address request
     * @return string
     * @throws \SimpleUPS\Api\MissingParameterException
     */
    public function buildXml()
    {
        if (serialize($this->getAddress()) == serialize(new Address())) {
            throw new MissingParameterException(
                'Address requires a Country code and a City, a State\Province code or a Postal code'
            );
        }

        if ($this->getAddress()->getCountryCode() === null) {
            throw new MissingParameterException('Address requires a Country code');
        }

        $dom = new \DomDocument('1.0');
        $dom->formatOutput = $this->getDebug();
        $dom->appendChild($addressRequest = $dom->createElement('AddressValidationRequest'));
        $addressRequestLang = $dom->createAttribute('xml:lang');
        $addressRequestLang->value = parent::getXmlLang();
        $addressRequest->appendChild($request = $dom->createElement('Request'));
        $request->appendChild($transactionReference = $dom->createElement('TransactionReference'));
        $transactionReference->appendChild($dom->createElement('CustomerContext', $this->getCustomerContext()));

        $request->appendChild($dom->createElement('RequestAction', 'XAV'));
        $request->appendChild($dom->createElement('RequestOption', '1'));

        $addressRequest->appendChild($address = $dom->createElement('AddressKeyFormat'));

        $address->appendChild($dom->createElement('AddressLine', $this->getAddress()->getStreet()));
        if ($this->getAddress()->getCity() != null) {
            $address->appendChild($dom->createElement('PoliticalDivision2', $this->getAddress()->getCity()));
        }

        if ($this->getAddress()->getStateProvinceCode() != null) {
            $address->appendChild(
                $dom->createElement('PoliticalDivision1', $this->getAddress()->getStateProvinceCode())
            );
        }

        if ($this->getAddress()->getPostalCode() != null) {
            $address->appendChild($dom->createElement('PostcodePrimaryLow', $this->getAddress()->getPostalCode()));
        }

        $address->appendChild($dom->createElement('CountryCode', $this->getAddress()->getCountryCode()));
        $xml = parent::buildAuthenticationXml() . $dom->saveXML();

        return $xml;
    }

    /**
     * @return Response|\SimpleUPS\Api\Response|\SimpleXMLElement
     */
    public function sendRequest()
    {
        $xml = parent::sendRequest();

        $responseClass = new \SimpleUPS\AddressValidate\Response($this->getAddress());
        $response = $responseClass->fromXml($xml);
        
        return $response;
    }

    /**
     * @param Address $address
     *
     * @return Request
     */
    public function setAddress(\SimpleUPS\Address $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }
}