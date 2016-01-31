<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Adapter;

use Hackathon\AddressValidation\Lookup\Config;
use Hackathon\AddressValidation\Lookup\Request\AddressRequestInterface;
use Magento\Quote\Model\Quote\AddressFactory;

/**
 * Factory for address lookup adapters.
 *
 * @package Hackathon\AddressValidation\Lookup\Adapter
 */
class AdapterFactory
{
    /**
     * Factory for address models.
     *
     * @var AddressFactory $addressFactory
     */
    protected $addressFactory;

    /**
     * The lookup configuration.
     *
     * @var Config
     */
    protected $config;

    /**
     * AddressFactory constructor.
     *
     * @param AddressFactory $addressFactory
     * @param Config $config
     */
    public function __construct(
        AddressFactory $addressFactory,
        Config $config
    ) {
        $this->addressFactory = $addressFactory;
        $this->config = $config;
    }

    /**
     * Get a list of address lookup adapters for the supplied address request.
     *
     * @param AddressRequestInterface $request
     * @return AdapterInterface[]
     */
    public function create(AddressRequestInterface $request)
    {
        return array_filter(
            array_map(
                function (array $adapter) {
                    $options = !empty($adapter['options'])
                        ? $adapter['options']
                        : [];

                    return new $adapter['class'](
                        $this->addressFactory,
                        $options
                    );
                },
                $this
                    ->config
                    ->getEnabledAdapters()
            ),
            function (AdapterInterface $adapter) use ($request) {
                return $adapter->canHandleRequest($request);
            }
        );
    }
}
