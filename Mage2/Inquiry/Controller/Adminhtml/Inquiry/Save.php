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
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Mage2\Inquiry\Api\InquiryRepositoryInterface;
use Mage2\Inquiry\Model\Inquiry;
use Mage2\Inquiry\Model\InquiryFactory;
use Mage2\Inquiry\Helper\Data as HelperData;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

/**
 * Class Save
 *
 * @package Mage2\Inquiry\Controller\Adminhtml\Inquiry
 */
class Save extends \Mage2\Inquiry\Controller\Adminhtml\Inquiry implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var InquiryFactory
     */
    protected $inquiryFactory;

    /**
     * @var InquiryRepositoryInterface
     */
    protected $inquiryRepository;

    /**
     * @var HelperData $helperData
     */
    protected $helperData;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Save constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param InquiryFactory $inquiryFactory
     * @param InquiryRepositoryInterface $inquiryRepository
     * @param HelperData $helperData
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        InquiryFactory $inquiryFactory,
        InquiryRepositoryInterface $inquiryRepository,
        HelperData $helperData,
        LoggerInterface $logger
    ) {
        $this->dataPersistor     = $dataPersistor;
        $this->inquiryFactory    = $inquiryFactory;
        $this->inquiryRepository = $inquiryRepository;
        $this->helperData        = $helperData;
        $this->logger            = $logger;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Inquiry::STATUS_ENABLED;
            }
            if (empty($data['inquiry_id'])) {
                $data['inquiry_id'] = null;
            }

            /** @var Inquiry $model */
            $model = $this->inquiryFactory->create();

            $id = $this->getRequest()->getParam('inquiry_id');
            if ($id) {
                try {
                    $model = $this->inquiryRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This inquiry no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $data['created_at'] = (date('Y-m-d H:i:s'));
            }

            $model->setData($data);

            try {
                $this->inquiryRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the inquiry.'));
                if ($data['send_email'] && $data['send_email'] != null) {
                    try {
                        $this->helperData->sendAdminReplyEmail($data);
                        $this->messageManager->addSuccessMessage(__('You saved the inquiry & Email has been sent to customer.'));
                    } catch (Exception $e) {
                        $this->logger->error($e->getMessage());
                        $this->messageManager->addSuccessMessage(__('There is some error, email has not been sent to customer.'));
                    }
                }
                $this->dataPersistor->clear('mage2_inquiry');
                return $this->processInquiryReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the inquiry.'));
            }

            $this->dataPersistor->set('mage2_inquiry', $data);
            return $resultRedirect->setPath('*/*/edit', ['inquiry_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the Inquiry return
     *
     * @param $model
     * @param $data
     * @param $resultRedirect
     * @return mixed
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    private function processInquiryReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['inquiry_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->inquiryFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $duplicateModel->setStatus(Inquiry::STATUS_DISABLED);
            $this->inquiryRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the inquiry.'));
            $this->dataPersistor->set('mage2_inquiry', $data);
            $resultRedirect->setPath('*/*/edit', ['inquiry_id' => $id]);
        }
        return $resultRedirect;
    }
}
