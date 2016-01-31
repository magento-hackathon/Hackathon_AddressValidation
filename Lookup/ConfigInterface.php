<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace Hackathon\AddressValidation\Lookup;


/**
 * Configuration for the lookup service.
 *
 * @package Hackathon\AddressValidation\Lookup
 */
interface ConfigInterface
{
    /**
     * Tells whether the extension is enabled.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Get a list of available adapters and their configuration.
     *
     * @return array
     */
    public function getAvailableAdapters();

    /**
     * Get a list of enabled adapters and their configuration.
     *
     * @return array
     */
    public function getEnabledAdapters();
}
