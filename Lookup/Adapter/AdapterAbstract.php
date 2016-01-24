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
     * The separator between property name and index.
     *
     * @var string PROPERTY_INDEX_SEPARATOR
     */
    const PROPERTY_INDEX_SEPARATOR = ':';

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
     * @return AddressInterface[]
     * @throws AddressNotFoundException when the request could not resolve to
     *   an address.
     * @throws InvalidAddressException when the adapter resolved to an
     *   invalid address.
     */
    final public function getAddresses(AddressRequestInterface $request)
    {
        try {
            $addresses = $this->processAddressRequest($request);
        } catch (\Exception $e) {
            throw new InvalidAddressException(
                sprintf(
                    'An error occurred with address adapter: %s',
                    get_class($this)
                )
            );
        }

        if (empty($addresses)) {
            throw new AddressNotFoundException(
                'Could not find an address for the supplied request.'
            );
        }

        foreach ($addresses as $address) {
            if (!($address instanceof AddressInterface)) {
                throw new InvalidAddressException(
                    sprintf(
                        'Invalid address %s returned from adapter %s',
                        get_class($address),
                        get_class($this)
                    )
                );
            }
        }

        return $addresses;
    }

    /**
     * Process the supplied address request and deliver an address entity.
     *
     * @param AddressRequestInterface $request
     * @return AddressInterface[]
     */
    abstract protected function processAddressRequest(
        AddressRequestInterface $request
    );

    /**
     * Whether the current adapter can handle the given request for addresses.
     *
     * @param AddressRequestInterface $request
     * @return boolean
     */
    final public function canHandleRequest(AddressRequestInterface $request)
    {
        $requiredProperties = array_unique(
            array_merge(
                // The country is always required.
                [AddressInterface::KEY_COUNTRY_ID],
                $this->getRequiredProperties()
            )
        );

        $availableProperties = array_map(
            function ($property) use ($request) {
                return $this->requestHasProperty($request, $property);
            },
            $requiredProperties
        );

        return count($requiredProperties) === array_sum($availableProperties);
    }

    /**
     * Check if the given property is set on the given request.
     *
     * @param AddressRequestInterface $request
     * @param string $property
     * @return bool
     */
    final protected function requestHasProperty(
        AddressRequestInterface $request,
        $property
    ) {
        static $mapping = [
            AddressInterface::KEY_CITY => 'hasCity',
            AddressInterface::KEY_COMPANY => 'hasCompany',
            AddressInterface::KEY_POSTCODE => 'hasPostcode',
            AddressInterface::KEY_STREET => 'hasStreet',
            AddressInterface::KEY_COUNTRY_ID => 'hasCountryId',
            AddressInterface::KEY_REGION_ID => 'hasRegionId',
            AddressInterface::KEY_REGION => 'hasRegion',
            AddressInterface::KEY_REGION_CODE => 'hasRegionCode'
        ];

        list($property, $index) = explode(
            static::PROPERTY_INDEX_SEPARATOR,
            $property . ':',
            2
        );

        return (
            array_key_exists($property, $mapping)
            && $request->{$mapping[$property]}((int) $index)
        );
    }

    /**
     * Get a list of properties that are required by the current adapter.
     *
     * @return string[]
     */
    abstract protected function getRequiredProperties();
}