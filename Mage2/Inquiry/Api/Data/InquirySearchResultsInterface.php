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

namespace Mage2\Inquiry\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface InquirySearchResultsInterface
 *
 * @package Mage2\Inquiry\Api\Data
 */
interface InquirySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get inquiry list.
     *
     * @return InquiryInterface[]
     */
    public function getItems();

    /**
     * Set inquiry list.
     *
     * @param InquiryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
