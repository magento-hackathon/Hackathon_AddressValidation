<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Config\AdapterList;

use Hackathon\AddressValidation\Lookup\ConfigInterface;
use Magento\Framework\Data\OptionSourceInterface;

class Source implements OptionSourceInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Source constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $adapters = [];

        foreach ($this->config->getAvailableAdapters() as $adapterName => $adapter) {
            $adapters[$adapterName] = [
                'value' => $adapterName,
                'label' => $adapter['label']
            ];
        }

        return $adapters;
    }
}
