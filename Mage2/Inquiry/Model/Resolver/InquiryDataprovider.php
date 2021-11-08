<?php
/**
 * Mage2developer
 * Copyright (C) 2021 Mage2developer
 *
 * @category Mage2developer
 * @package Mage2_Inquiry
 * @copyright Copyright (c) 2021 Mage2developer
 * @author Mage2developer <mage2developer@gmail.com>
 */

declare(strict_types=1);

namespace Mage2\Inquiry\Model\Resolver;

use Mage2\Inquiry\Api\InquiryRepositoryInterface;
use Mage2\Inquiry\Helper\Data as HelperData;
use Mage2\Inquiry\Model\InquiryFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

/**
 * @package Mage2\Inquiry\Model\Resolver
 */
class InquiryDataprovider
{
    /**
     * @var HelperData $helperData
     */
    protected $helperData;

    /**
     * @var InquiryFactory
     */
    protected $inquiryFactory;

    /**
     * @var InquiryRepositoryInterface
     */
    protected $inquiryRepository;

    /**
     * @param HelperData $helperData
     * @param InquiryRepositoryInterface $inquiryRepository
     * @param InquiryFactory $inquiryFactory
     */
    public function __construct(
        HelperData $helperData,
        InquiryRepositoryInterface $inquiryRepository,
        InquiryFactory $inquiryFactory
    ) {
        $this->helperData = $helperData;
        $this->inquiryRepository = $inquiryRepository;
        $this->inquiryFactory = $inquiryFactory;
    }

    /**
     * @param $input
     * @return int
     * @throws GraphQlInputException
     */
    public function createNewInquiry($input)
    {
        $inquiryData = [];
        $inquiry = $this->inquiryFactory->create();
        $input['status'] = 1;

        try {
            $inquiry->setData($input);
            $this->inquiryRepository->save($inquiry);
            $inquiryData = $inquiry->getData();

            try {
                $this->helperData->sendCustomerEmail($inquiry);
            } catch (\Exception $e) {
                throw new GraphQlInputException(__($e->getMessage()));
            }

            if ($this->helperData->isEmailSendToAdmin()) {
                try {
                    $this->helperData->sendAdminEmail($input);
                } catch (LocalizedException $e) {
                    throw new GraphQlInputException(__($e->getMessage()));
                }
            }

        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        return $inquiryData;
    }
}
