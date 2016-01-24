<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Lookup;

use Hackathon\AddressValidation\Lookup\Adapter\AdapterFactory;
use Hackathon\AddressValidation\Lookup\Request\AddressRequest;
use Hackathon\AddressValidation\Lookup\Request\AddressRequestInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Quote\Api\Data\AddressInterface;

class Service implements ServiceInterface
{
    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    /**
     * Service constructor.
     * @param AdapterFactory $adapterFactory
     */
    public function __construct(AdapterFactory $adapterFactory)
    {
        $this->adapterFactory = $adapterFactory;
    }

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
    public function getAddresses(AddressRequestInterface $request)
    {
        $countryCode = $request->getCountryId();

        if (empty($countryCode)) {
            throw new InvalidAddressException('Missing country code');
        }

        $adapter = null;
        $adapters = $this->adapterFactory->create($countryCode);

        $addresses = [];

        foreach ($adapters as $adapter) {
            $addresses = $adapter->getAddresses($request);

            if (!empty($addresses)) {
                break;
            }
        }

        if (empty($addresses)) {
            throw new AddressNotFoundException(
                'Could not find an address for the given request.'
            );
        }

        foreach ($addresses as $address) {
            if (!($address instanceof AddressInterface)) {
                throw new InvalidAddressException(
                    sprintf(
                        'Invalid address %s supplied by adapter: %s',
                        get_class($address),
                        get_class($adapter)
                    )
                );
            }
        }

        return $addresses;
    }

    /**
     * Get an address for the supplied request parameters.
     *
     * @param string[] $params
     * @return AddressInterface[]
     */
    public function getAddressesFromRequestParams(array $params)
    {
        return $this->getAddresses(
            $this->createRequest($params)
        );
    }

    /**
     * Create an address request for the supplied list of params.
     *
     * @param string[] $params
     * @return AddressRequestInterface
     */
    public function createRequest(array $params)
    {
        return new AddressRequest($params);
    }

    /**
     * Get an address for the supplied Magento App Request.
     *
     * @param RequestInterface $request
     * @return AddressInterface[]
     */
    public function getAddressesFromRequest(RequestInterface $request)
    {
        return $this->getAddressesFromRequestParams(
            $request->getParams()
        );
    }
}