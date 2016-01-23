<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Adapter;

use Hackathon\AddressValidation\Lookup\AddressNotFoundException;
use Hackathon\AddressValidation\Lookup\InvalidAddressException;
use Hackathon\AddressValidation\Lookup\Request\AddressRequestInterface;
use Magento\Quote\Api\Data\AddressInterface;

/**
 * Interface for address lookup adapters.
 *
 * @package Hackathon\AddressValidation\Lookup\Adapter
 */
interface AdapterInterface
{
    /**
     * Get an address for the supplied address request.
     *
     * @param AddressRequestInterface $request
     * @return AddressInterface
     * @throws AddressNotFoundException when the request could not resolve to
     *   an address.
     * @throws InvalidAddressException when the adapter resolved to an
     *   invalid address.
     */
    public function getAddress(AddressRequestInterface $request);
}