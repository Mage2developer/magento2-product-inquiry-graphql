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

namespace Mage2\Inquiry\Model;

use Magento\Framework\Model\AbstractModel;
use Mage2\Inquiry\Api\Data\InquiryInterface;

/**
 * Class Inquiry
 *
 * @package Mage2\Inquiry\Model
 */
class Inquiry extends AbstractModel implements InquiryInterface
{
    const CACHE_TAG       = 'inquiry_b';
    const STATUS_ENABLED  = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'mage2_inquiry';

    /**
     * @var string
     */
    protected $_idFieldName = self::INQUIRY_ID;

    /**
     * Prepare inquiry statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('New'), self::STATUS_DISABLED => __('Replied')];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::INQUIRY_ID);
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return (string)$this->getData(self::NAME);
    }

    /**
     * Get Mobile Number
     *
     * @return int|null
     */
    public function getMobileNumber()
    {
        return $this->getData(self::MOBILE_NUMBER);
    }

    /**
     * Get Message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Get Product Sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * Get Display in front setting
     *
     * @return boolean|null
     */
    public function getDisplayFront()
    {
        return $this->getData(self::DISPLAY_FRONT);
    }

    /**
     * Get Admin message
     *
     * @return string|null
     */
    public function getAdminMessage()
    {
        return $this->getData(self::ADMIN_MESSAGE);
    }

    /**
     * Get Status
     *
     * @return boolean|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return InquiryInterface
     */
    public function setId($id)
    {
        return $this->setData(self::INQUIRY_ID, $id);
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return InquiryInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set Mobile Number
     *
     * @param string $mobile_number
     * @return InquiryInterface
     */
    public function setMobileNumber($mobile_number)
    {
        return $this->setData(self::MOBILE_NUMBER, $mobile_number);
    }

    /**
     * Set message
     *
     * @param string $message
     * @return InquiryInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return InquiryInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set Product Sku
     *
     * @param string $sku
     * @return InquiryInterface
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Set Display in front setting
     *
     * @param bool|int $display_front
     * @return InquiryInterface
     */
    public function setDisplayFront($display_front)
    {
        return $this->setData(self::DISPLAY_FRONT, $display_front);
    }

    /**
     * Set Admin Message
     *
     * @param string $admin_message
     * @return InquiryInterface
     */
    public function setAdminMessage($admin_message)
    {
        return $this->setData(self::ADMIN_MESSAGE, $admin_message);
    }

    /**
     * Set Status
     *
     * @param bool|int $status
     * @return InquiryInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mage2\Inquiry\Model\ResourceModel\Inquiry::class);
    }
}
