<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Adapter;

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
     * AddressFactory constructor.
     *
     * @param AddressFactory $addressFactory
     */
    public function __construct(AddressFactory $addressFactory)
    {
        $this->addressFactory = $addressFactory;
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
            [
                new MediaCTAdapter($this->addressFactory)
            ],
            function (AdapterInterface $adapter) use ($request) {
                return $adapter->canHandleRequest($request);
            }
        );
    }
}