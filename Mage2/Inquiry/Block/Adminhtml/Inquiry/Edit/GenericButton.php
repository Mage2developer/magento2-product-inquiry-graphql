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

namespace Mage2\Inquiry\Block\Adminhtml\Inquiry\Edit;

use Magento\Backend\Block\Widget\Context;
use Mage2\Inquiry\Api\InquiryRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 *
 * @package Mage2\Inquiry\Block\Adminhtml\Inquiry\Edit
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var InquiryRepositoryInterface
     */
    protected $inquiryRepository;

    /**
     * GenericButton constructor.
     *
     * @param Context $context
     * @param InquiryRepositoryInterface $inquiryRepository
     */
    public function __construct(
        Context $context,
        InquiryRepositoryInterface $inquiryRepository
    ) {
        $this->context           = $context;
        $this->inquiryRepository = $inquiryRepository;
    }

    /**
     * Get product inquiry id from url params
     *
     * @return int|null
     * @throws NoSuchEntityException
     */
    public function getInquiryId()
    {
        try {
            return $this->inquiryRepository->getById(
                $this->context->getRequest()->getParam('inquiry_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
