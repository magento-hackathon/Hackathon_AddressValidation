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
use Magento\Quote\Model\Quote\AddressFactory;

abstract class AdapterAbstract implements AdapterInterface
{
    /**
     * The factory for address models.
     *
     * @var AddressFactory
     */
    private $addressFactory;

    /**
     * AdapterAbstract constructor.
     * @param AddressFactory $addressFactory
     */
    public function __construct(AddressFactory $addressFactory)
    {
        $this->addressFactory = $addressFactory;
    }

    /**
     * AddressFactory getter.
     *
     * @return AddressFactory
     */
    protected function getAddressFactory()
    {
        return $this->addressFactory;
    }

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
    final public function getAddress(AddressRequestInterface $request)
    {
        try {
            $address = $this->processAddressRequest($request);
        } catch (\Exception $e) {
            throw new InvalidAddressException(
                sprintf(
                    'An error occurred with address adapter: %s',
                    get_class($this)
                )
            );
        }

        if (!($address instanceof AddressInterface)) {
            throw new AddressNotFoundException(
                'Could not find an address for the supplied request.'
            );
        }

        return $address;
    }

    /**
     * Process the supplied address request and deliver an address entity.
     *
     * @param AddressRequestInterface $request
     * @return AddressInterface|null
     */
    abstract protected function processAddressRequest(
        AddressRequestInterface $request
    );
}