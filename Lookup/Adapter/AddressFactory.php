<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup\Adapter;

use Magento\Quote\Model\Quote\AddressFactory as QuoteAddressFactory;

class AddressFactory
{
    /**
     * @var QuoteAddressFactory $quoteAddressFactory
     */
    protected $quoteAddressFactory;

    /**
     * AddressFactory constructor.
     * @param QuoteAddressFactory $quoteAddressFactory
     */
    public function __construct(QuoteAddressFactory $quoteAddressFactory)
    {
        $this->quoteAddressFactory = $quoteAddressFactory;
    }

    /**
     * @param string|null $countryCode
     * @return AdapterInterface[]
     */
    public function create($countryCode = null)
    {
        return [
            new MediaCTAdapter($this->quoteAddressFactory)
        ];
    }
}