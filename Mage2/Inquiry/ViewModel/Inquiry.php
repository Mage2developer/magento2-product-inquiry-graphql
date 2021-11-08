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

namespace Mage2\Inquiry\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Mage2\Inquiry\Helper\Data;
use Mage2\Inquiry\Model\ResourceModel\Inquiry\Collection;
use Mage2\Inquiry\Model\ResourceModel\Inquiry\CollectionFactory;

/**
 * Class Inquiry
 *
 * @package Mage2\Inquiry\ViewModel
 */
class Inquiry implements ArgumentInterface
{
    /**
     * @var UrlInterface
     */
    protected $urlInterface;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * @var CollectionFactory
     */
    protected $inquiryCollectionFactory;

    /**
     * Inquiry constructor.
     * @param Registry $registry
     * @param UrlInterface $urlInterface
     * @param Data $dataHelper
     * @param CollectionFactory $inquiryCollectionFactory
     */
    public function __construct(
        Registry $registry,
        UrlInterface $urlInterface,
        Data $dataHelper,
        CollectionFactory $inquiryCollectionFactory
    ) {
        $this->registry = $registry;
        $this->urlInterface = $urlInterface;
        $this->dataHelper = $dataHelper;
        $this->inquiryCollectionFactory = $inquiryCollectionFactory;
    }

    /**
     * Get product inquiry form action url
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->urlInterface->getUrl('inquiry/index/post/', ['_secure' => true]);
    }

    /**
     * Get current product's SKU
     *
     * @return mixed
     */
    public function getCurrentProductSku()
    {
        $product = $this->registry->registry('current_product');
        return $product->getSku();
    }

    /**
     * Get product inquiry questions list
     *
     * @return Collection
     */
    public function getInquiryCollection()
    {
        $questionDisplayCount = $this->dataHelper->getQuestionCount();

        $collection = $this->inquiryCollectionFactory->create();
        $collection->addFieldToFilter('sku', $this->getCurrentProductSku());
        $collection->addFieldToFilter('display_front', '1');
        $collection->setPageSize($questionDisplayCount);
        return $collection;
    }

    /**
     * Get the question display setting value whether inquiry questions should display above the inquiry form
     *
     * @return mixed
     */
    public function getQuestionDisplaySetting()
    {
        return $this->dataHelper->getQuestionDisplaySetting();
    }
}
