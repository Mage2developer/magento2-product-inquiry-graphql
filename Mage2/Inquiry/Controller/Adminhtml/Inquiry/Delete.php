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
use Mage2\Inquiry\Model\InquiryRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;

/**
 * Class Delete
 *
 * @package Mage2\Inquiry\Controller\Adminhtml\Inquiry
 */
class Delete extends Action
{
    /**
     * @var InquiryRepository
     */
    protected $inquiryRepository;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param InquiryRepository $inquiryRepository
     */
    public function __construct(
        Context $context,
        inquiryRepository $inquiryRepository
    ) {
        $this->inquiryRepository = $inquiryRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id             = $this->getRequest()->getParam('inquiry_id');
        if ($id) {
            try {
                $this->inquiryRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The item has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['inquiry_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a item to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
