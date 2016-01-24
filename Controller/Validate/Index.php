<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

namespace Hackathon\AddressValidation\Controller\Validate;

use Hackathon\AddressValidation\Lookup\AddressException;
use Hackathon\AddressValidation\Lookup\ServiceInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json\Interceptor;
use Magento\Framework\Controller\ResultFactory;
use Magento\Quote\Api\Data\AddressInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * The address lookup service.
     *
     * @var ServiceInterface
     */
    protected $addressLookupService;

    public function __construct(
        Context $context//,
        //ServiceInterface $addressLookupService
    ) {
        parent::__construct($context);
        $this->addressLookupService = $this
            ->_objectManager
            ->get('Hackathon\AddressValidation\Lookup\Service');
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $addresses = [];

        try {
            $addresses = $this
                ->addressLookupService
                ->getAddressesFromRequest(
                    $this->getRequest()
                );
        } catch (AddressException $e) {
            // Nothing to do here.
        }

        /** @var Interceptor $response */
        $response = $this
            ->resultFactory
            ->create(ResultFactory::TYPE_JSON);

        $response->setData([
            'valid' => !empty($addresses),
            'suggestions' => array_map(
                [$this, 'convertAddressToSuggestion'],
                $addresses
            )
        ]);

        return $response;
    }

    /**
     * Convert the address into an array of key-value-pairs.
     *
     * @param AddressInterface $address
     * @return string[]|string[][]
     */
    protected function convertAddressToSuggestion(AddressInterface $address)
    {
        return array_filter(
            [
                AddressInterface::KEY_CITY => $address->getCity(),
                AddressInterface::KEY_COMPANY => $address->getCompany(),
                AddressInterface::KEY_POSTCODE => $address->getPostcode(),
                AddressInterface::KEY_STREET => $address->getStreet(),
                AddressInterface::KEY_COUNTRY_ID => $address->getCountryId(),
                AddressInterface::KEY_REGION_ID => $address->getRegionId(),
                AddressInterface::KEY_REGION => $address->getRegion(),
                AddressInterface::KEY_REGION_CODE => $address->getRegionCode()
            ]
        );
    }
}