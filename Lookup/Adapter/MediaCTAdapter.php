<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Adapter;

use Hackathon\AddressValidation\Lookup\Request\AddressRequestInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address;

class MediaCTAdapter extends AdapterAbstract
{
    /**
     * Process the supplied address request and deliver an address entity.
     *
     * @param AddressRequestInterface $request
     * @return AddressInterface[]
     */
    protected function processAddressRequest(
        AddressRequestInterface $request
    ) {
        $address = null;
        if ($request->getPostCode() === '9724AH'
            // Check the second index of the list of streets.
            && $request->getStreet(1) === '22'
        ) {
            $address = $this
                ->getAddressFactory()
                ->create();

            $address->setCity('Groningen');
            $address->setCompany('MediaCT B.V.');
            $address->setPostcode($request->getPostCode());
            $address->setStreet(['ZuiderPark', $request->getStreet(1)]);
        }

        return [$address];
    }
}