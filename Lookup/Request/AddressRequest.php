<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Request;


use Magento\Quote\Api\Data\AddressInterface;

class AddressRequest implements AddressRequestInterface
{
    /**
     * @var string|null
     */
    protected $countryId;

    /**
     * @var string|null
     */
    protected $regionId;

    /**
     * @var string|null
     */
    protected $region;

    /**
     * @var string|null
     */
    protected $regionCode;

    /**
     * @var string|null
     */
    protected $street;

    /**
     * @var string|null
     */
    protected $street2;

    /**
     * @var string|null
     */
    protected $postCode;

    /**
     * @var string|null
     */
    protected $city;

    public function __construct(array $params = [])
    {
        static $indexes = [
            AddressInterface::KEY_COUNTRY_ID => 'countryId',
            AddressInterface::KEY_REGION_ID => 'regionId',
            AddressInterface::KEY_REGION => 'region',
            AddressInterface::KEY_REGION_CODE => 'regionCode',
            AddressInterface::KEY_POSTCODE => 'postCode',
            AddressInterface::KEY_CITY => 'city'
        ];

        if (!empty($params['street'])) {
            $this->street = array_shift($params['street']) ?: null;
            $this->street2 = array_shift($params['street']) ?: null;
        }

        foreach ($indexes as $index => $property) {
            if (!empty($params[$index])) {
                $this->{$property} = $params[$index];
            }
        }
    }

    /**
     * CountryId getter.
     *
     * @return null|string
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * RegionId getter.
     *
     * @return null|string
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * Region getter.
     *
     * @return null|string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * RegionCode getter.
     *
     * @return null|string
     */
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * Street getter.
     *
     * @return null|string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Street2 getter.
     *
     * @return null|string
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * PostCode getter.
     *
     * @return null|string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * City getter.
     *
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }
}