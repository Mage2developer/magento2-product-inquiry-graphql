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

namespace Mage2\Inquiry\Model\ResourceModel\Inquiry;

use Mage2\Inquiry\Model\Inquiry;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package Mage2\Inquiry\Model\ResourceModel\Inquiry
 */
class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = Inquiry::INQUIRY_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mage2\Inquiry\Model\Inquiry', 'Mage2\Inquiry\Model\ResourceModel\Inquiry');
    }
}
