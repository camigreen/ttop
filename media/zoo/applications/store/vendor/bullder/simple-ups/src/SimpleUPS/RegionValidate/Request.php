<?php namespace SimpleUPS\RegionValidate;

use \SimpleUPS\Api\MissingParameterException;

use \SimpleUPS\Address;

use \SimpleUPS\UPS;

/**
 * @internal
 */
class Request extends \SimpleUPS\Api\Request
{
    private
        /* @var Address $address */
        $address;

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
        return $this->getDebug() ? 'https://wwwcie.ups.com/ups.app/xml/AV' : 'https://onlinetools.ups.com/ups.app/xml/AV';
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
                'Address requires a Country code, Postal code, and either a City or State\Province code'
            );
        }

        if ($this->getAddress()->getCountryCode() === null) {
            throw new MissingParameterException('Address requires a Country code');
        }

        if ($this->getAddress()->getPostalCode() === null) {
            throw new MissingParameterException('Address requires a Postal code');
        }

        $dom = new \DomDocument('1.0');
        $dom->formatOutput = $this->getDebug();
        $dom->appendChild($addressRequest = $dom->createElement('AddressValidationRequest'));
        $addressRequestLang = $dom->createAttribute('xml:lang');
        $addressRequestLang->value = parent::getXmlLang();
        $addressRequest->appendChild($request = $dom->createElement('Request'));
        $request->appendChild($transactionReference = $dom->createElement('TransactionReference'));
        $transactionReference->appendChild($dom->createElement('CustomerContext', $this->getCustomerContext()));
        $transactionReference->appendChild($dom->createElement('XpciVersion', $this->getXpciVersion()));

        $request->appendChild($dom->createElement('RequestAction', 'AV'));
        $addressRequest->appendChild($address = $dom->createElement('Address'));

        if ($this->getAddress()->getCity() != null) {
            $address->appendChild($dom->createElement('City', $this->getAddress()->getCity()));
        }

        if ($this->getAddress()->getStateProvinceCode() != null) {
            $address->appendChild(
                $dom->createElement('StateProvinceCode', $this->getAddress()->getStateProvinceCode())
            );
        }

        if ($this->getAddress()->getPostalCode() != null) {
            $address->appendChild($dom->createElement('PostalCode', $this->getAddress()->getPostalCode()));
        }
        $address->appendChild($dom->createElement('CountryCode', $this->getAddress()->getCountryCode()));

        $xml = parent::buildAuthenticationXml() . $dom->saveXML();

        return $xml;
    }

    /**
     * Send a request to the API and get region rankings for the provided address
     * @return Response
     */
    public function sendRequest()
    {

        $xml = parent::sendRequest();
        $responseClass = new \SimpleUPS\RegionValidate\Response($this->getAddress());
        $response = $responseClass->fromXml($xml);
        var_dump($response);
        return $response;
    }

    /**
     * @param \SimpleUPS\Address $address
     */
    public function setAddress(\SimpleUPS\Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }
}