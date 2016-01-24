<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Adapter;

use Magento\Quote\Model\Quote\AddressFactory;

class AdapterFactory
{
    /**
     * @var AddressFactory $addressFactory
     */
    protected $addressFactory;

    /**
     * AddressFactory constructor.
     * @param AddressFactory $addressFactory
     */
    public function __construct(AddressFactory $addressFactory)
    {
        $this->addressFactory = $addressFactory;
    }

    /**
     * @param string|null $countryCode
     * @return AdapterInterface[]
     */
    public function create($countryCode = null)
    {
        return [
            new MediaCTAdapter($this->addressFactory)
        ];
    }
}