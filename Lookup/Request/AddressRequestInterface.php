<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Request;

/**
 * Interface for address validation requests.
 *
 * @package Hackathon\AddressValidation\Lookup\Request
 */
interface AddressRequestInterface
{
    /**
     * @return string|null
     */
    public function getCountryId();

    /**
     * @return string|null
     */
    public function getRegionId();

    /**
     * @return string|null
     */
    public function getRegion();

    /**
     * @return string|null
     */
    public function getRegionCode();

    /**
     * @return string|null
     */
    public function getStreet();

    /**
     * @return string|null
     */
    public function getStreet2();

    /**
     * @return string|null
     */
    public function getPostCode();

    /**
     * @return string|null
     */
    public function getCity();
}