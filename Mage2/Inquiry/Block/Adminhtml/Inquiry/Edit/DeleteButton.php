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

namespace Mage2\Inquiry\Block\Adminhtml\Inquiry\Edit;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 *
 * @package Mage2\Inquiry\Block\Adminhtml\Inquiry\Edit
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get delete button data
     *
     * @return array
     * @throws LocalizedException
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getInquiryId()) {
            $data = [
                'label'      => __('Delete Inquiry'),
                'class'      => 'delete',
                'on_click'   => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?') . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Get delete button redirect url
     *
     * @return string
     * @throws LocalizedException
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['inquiry_id' => $this->getInquiryId()]);
    }
}
