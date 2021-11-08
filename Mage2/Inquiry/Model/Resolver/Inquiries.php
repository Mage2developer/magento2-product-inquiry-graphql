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

use Mage2\Inquiry\Helper\Data;
use Mage2\Inquiry\Model\ResourceModel\Inquiry\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * @package Mage2\Inquiry\Model\Resolver
 */
class Inquiries implements ResolverInterface
{
    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * @var CollectionFactory
     */
    protected $inquiryCollectionFactory;

    /**
     * @param Data $dataHelper
     * @param CollectionFactory $inquiryCollectionFactory
     */
    public function __construct(
        Data $dataHelper,
        CollectionFactory $inquiryCollectionFactory
    ) {
        $this->dataHelper               = $dataHelper;
        $this->inquiryCollectionFactory = $inquiryCollectionFactory;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     * @throws GraphQlNoSuchEntityException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $this->checkArguments($args);
        $inquiriesData = $this->getInquiriesData($args);

        return $inquiriesData;
    }

    /**
     * @param array $args
     * @return array
     * @throws GraphQlInputException
     */
    private function checkArguments(array $args): array
    {
        if (!isset($args['sku']) && !isset($args['display_front'])) {
            throw new GraphQlInputException(__('"sku and display_front should be specified'));
        }

        return $args;
    }

    /**
     * @param $args
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getInquiriesData($args): array
    {
        $items = [];

        try {
            $questionDisplayCount = $this->dataHelper->getQuestionCount();

            $collection = $this->inquiryCollectionFactory->create();
            $collection->addFieldToFilter('sku', $args['sku'])
                ->addFieldToFilter('display_front', $args['display_front'])
                ->setPageSize($questionDisplayCount)
                ->setOrder('created_at', 'DESC');

            $totalCount = $collection->getSize();

            if ($totalCount > 0) {
                $items = $collection->getData();
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        $inquiryData = ['totalCount' => $totalCount, 'items' => $items];

        return $inquiryData;
    }
}
