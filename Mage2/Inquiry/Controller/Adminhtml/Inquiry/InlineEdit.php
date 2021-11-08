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

namespace Mage2\Inquiry\Controller\Adminhtml\Inquiry;

use Exception;
use Mage2\Inquiry\Model\Inquiry;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Mage2\Inquiry\Api\InquiryRepositoryInterface as InquiryRepository;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Mage2\Inquiry\Api\Data\InquiryInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class InlineEdit
 *
 * @package Mage2\Inquiry\Controller\Adminhtml\Inquiry
 */
class InlineEdit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mage2_Inquiry::inquiry';

    /**
     * @var InquiryRepository
     */
    protected $inquiryRepository;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param InquiryRepository $inquiryRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        InquiryRepository $inquiryRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->inquiryRepository = $inquiryRepository;
        $this->jsonFactory       = $jsonFactory;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\App\ResponseInterface|Json|ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error      = false;
        $messages   = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error      = true;
            } else {
                foreach (array_keys($postItems) as $inquiryId) {
                    /** @var Inquiry $inquiry */
                    $inquiry = $this->inquiryRepository->getById($inquiryId);
                    try {
                        $inquiry->setData(array_merge($inquiry->getData(), $postItems[$inquiryId]));
                        $this->inquiryRepository->save($inquiry);
                    } catch (Exception $e) {
                        $messages[] = $this->getErrorWithInquiryId(
                            $inquiry,
                            __($e->getMessage())
                        );
                        $error      = true;
                    }
                }
            }
        }

        return $resultJson->setData(['messages' => $messages, 'error' => $error]);
    }

    /**
     * Add Inquiry title to error message
     *
     * @param InquiryInterface $inquiry
     * @param $errorText
     * @return string
     */
    protected function getErrorWithInquiryId(InquiryInterface $inquiry, $errorText)
    {
        return '[Inquiry ID: ' . $inquiry->getId() . '] ' . $errorText;
    }
}
