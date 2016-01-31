<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Request;


use Hackathon\AddressValidation\Lookup\ConfigInterface;
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
     * @var string[]
     */
    protected $streets = [];

    /**
     * @var string|null
     */
    protected $postCode;

    /**
     * @var string|null
     */
    protected $city;

    /**
     * The maximum number of suggestions the adapter can make for this request.
     *
     * @var integer $maxSuggestions
     */
    protected $maxSuggestions;

    /**
     * AddressRequest constructor.
     *
     * @param array $params
     * @param ConfigInterface $config
     */
    public function __construct(array $params, ConfigInterface $config)
    {
        static $indexes = [
            AddressInterface::KEY_COUNTRY_ID => 'countryId',
            AddressInterface::KEY_REGION_ID => 'regionId',
            AddressInterface::KEY_REGION => 'region',
            AddressInterface::KEY_REGION_CODE => 'regionCode',
            AddressInterface::KEY_POSTCODE => 'postCode',
            AddressInterface::KEY_CITY => 'city',
            AddressInterface::KEY_STREET => 'streets'
        ];

        foreach ($indexes as $index => $property) {
            if (!empty($params[$index])) {
                $this->{$property} = $params[$index];
            }
        }

        $this->maxSuggestions = $config->getMaxSuggestions();
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
     * Streets getter.
     *
     * @return string[]
     */
    public function getStreets()
    {
        return $this->streets;
    }

    /**
     * Get the street for the given index, or the first street if no index
     * was specified.
     *
     * @param int $index
     * @return null|string
     */
    public function getStreet($index = 0)
    {
        return isset($this->streets[$index])
            ? (string) $this->streets[$index]
            : null;
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

    /**
     * @return bool
     */
    public function hasCountryId()
    {
        return !empty($this->countryId);
    }

    /**
     * @return bool
     */
    public function hasRegionId()
    {
        return !empty($this->regionId);
    }

    /**
     * @return bool
     */
    public function hasRegion()
    {
        return !empty($this->region);
    }

    /**
     * @return bool
     */
    public function hasRegionCode()
    {
        return !empty($this->regionCode);
    }

    /**
     * @return bool
     */
    public function hasStreet($index = 0)
    {
        return !empty($this->streets[$index]);
    }

    /**
     * @return bool
     */
    public function hasPostCode()
    {
        return !empty($this->postCode);
    }

    /**
     * @return bool
     */
    public function hasCity()
    {
        return !empty($this->city);
    }

    /**
     * MaxSuggestions getter.
     *
     * @return int
     */
    public function getMaxSuggestions()
    {
        return $this->maxSuggestions;
    }
}
