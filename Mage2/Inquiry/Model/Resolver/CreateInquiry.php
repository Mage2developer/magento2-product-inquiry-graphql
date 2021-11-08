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

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Class CreateInquiry
 */
class CreateInquiry implements ResolverInterface
{
    /**
     * @var InquiryDataprovider
     */
    protected $inquiryDataprovider;

    /**
     * @param InquiryDataprovider $inquiryDataprovider
     */
    public function __construct(
        InquiryDataprovider $inquiryDataprovider
    ) {
        $this->inquiryDataprovider = $inquiryDataprovider;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        $inquiryData = $this->inquiryDataprovider->createNewInquiry($args['input']);

        $data = ['inquiry' => $inquiryData];

        return $data;
    }
}
