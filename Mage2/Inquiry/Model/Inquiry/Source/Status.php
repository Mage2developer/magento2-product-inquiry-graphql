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

namespace Mage2\Inquiry\Model\Inquiry\Source;

use Mage2\Inquiry\Model\Inquiry;
use Magento\Cms\Model\Block;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 *
 * @package Mage2\Inquiry\Model\Inquiry\Source
 */
class Status implements OptionSourceInterface
{
    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * Constructor
     *
     * @param Inquiry $inquiry
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->inquiry->getAvailableStatuses();
        $options          = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
