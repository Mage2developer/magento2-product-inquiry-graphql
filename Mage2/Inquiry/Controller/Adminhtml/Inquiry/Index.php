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

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package Mage2\Inquiry\Controller\Adminhtml\Inquiry
 */
class Index extends Action
{
    const ADMIN_RESOURCE = 'Mage2_Inquiry::index';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mage2_Inquiry::inquiry');
        $resultPage->addBreadcrumb(__('Mage2'), __('Mage2'));
        $resultPage->addBreadcrumb(__('Manage Inquiry'), __('Manage Inquiry'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Inquiry'));

        return $resultPage;
    }
}
