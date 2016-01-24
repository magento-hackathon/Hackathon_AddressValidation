<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace Hackathon\AddressValidation\Lookup;

use Hackathon\AddressValidation\Lookup\Request\AddressRequestInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Quote\Api\Data\AddressInterface;

interface ServiceInterface
{
    /**
     * Get an address for the given request.
     *
     * @param AddressRequestInterface $request
     * @return AddressInterface[]
     * @throws InvalidAddressException when no country code is set.
     * @throws InvalidAddressException when an adapter returned an invalid
     *   address entity.
     * @throws AddressNotFoundException when no address can be found.
     */
    public function getAddresses(AddressRequestInterface $request);

    /**
     * Get an address for the supplied request parameters.
     *
     * @param string[] $params
     * @return AddressInterface[]
     */
    public function getAddressesFromRequestParams(array $params);

    /**
     * Create an address request for the supplied list of params.
     *
     * @param string[] $params
     * @return AddressRequestInterface
     */
    public function createRequest(array $params);

    /**
     * Get an address for the supplied Magento App Request.
     *
     * @param RequestInterface $request
     * @return AddressInterface[]
     */
    public function getAddressesFromRequest(RequestInterface $request);
}