<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Configuration for the lookup service.
 *
 * @package Hackathon\AddressValidation\Lookup
 */
class Config implements ConfigInterface
{
    /**
     * The config path to the enabled flag.
     *
     * @var string CONFIG_PATH_ENABLED
     */
    const CONFIG_PATH_ENABLED = 'checkout/address_validation/enabled';

    /**
     * The config path to the adapter configuration.
     *
     * @var string CONFIG_PATH_ADAPTERS
     */
    const CONFIG_PATH_ADAPTERS = 'checkout/address_validation/adapters';

    /**
     * The config path to the enabled adapter configuration.
     *
     * @var string CONFIG_PATH_ENABLED_ADAPTERS
     */
    const CONFIG_PATH_ENABLED_ADAPTERS = 'checkout/address_validation/enabled_adapters';

    /**
     * The config path for the maximum number of suggestions.
     *
     * @var string CONFIG_PATH_MAX_SUGGESTIONS
     */
    const CONFIG_PATH_MAX_SUGGESTIONS = 'checkout/address_validation/max_suggestions';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Tells whether the extension is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this
            ->scopeConfig
            ->isSetFlag(static::CONFIG_PATH_ENABLED);
    }

    /**
     * Get a list of available adapters and their configuration.
     *
     * @return array
     */
    public function getAvailableAdapters()
    {
        return $adapters = array_filter(
            $this
                ->scopeConfig
                ->getValue(static::CONFIG_PATH_ADAPTERS),
            [$this, 'validateAdapterConfig']
        );
    }

    /**
     * Tells whether the adapter config is valid to proceed.
     *
     * @param array $adapter
     * @return bool
     */
    protected function validateAdapterConfig(array $adapter)
    {
        return (!empty($adapter['class'])
            && !empty($adapter['label'])
            && class_exists($adapter['class'], true)
        );
    }

    /**
     * Get a list of enabled adapters and their configuration.
     *
     * @return array
     */
    public function getEnabledAdapters()
    {
        $adapters = [];

        if ($this->isEnabled()) {
            $enabled = array_fill_keys(
                explode(
                    ',',
                    (string) $this
                        ->scopeConfig
                        ->getValue(static::CONFIG_PATH_ENABLED_ADAPTERS)
                ),
                true
            );

            $adapters = array_intersect_key(
                $this->getAvailableAdapters(),
                $enabled
            );
        }

        return $adapters;
    }

    /**
     * Get the number of maximum suggestions.
     *
     * @return integer
     */
    public function getMaxSuggestions()
    {
        return $this->isEnabled()
            ? (int) $this
                ->scopeConfig
                ->getValue(static::CONFIG_PATH_MAX_SUGGESTIONS)
            : 0;
    }
}
