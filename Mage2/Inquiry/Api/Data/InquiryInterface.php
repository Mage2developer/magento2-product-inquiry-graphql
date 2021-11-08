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

/**
 * Interface InquiryInterface
 *
 * @package Mage2\Inquiry\Api\Data
 */
interface InquiryInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const INQUIRY_ID    = 'inquiry_id';
    const NAME          = 'name';
    const MOBILE_NUMBER = 'mobile_number';
    const MESSAGE       = 'message';
    const EMAIL         = 'email';
    const SKU           = 'SKU';
    const STATUS        = 'status';
    const DISPLAY_FRONT = 'display_front';
    const ADMIN_MESSAGE = 'admin_message';

    /**
     * Get ID
     *
     * @return int
     */
    public function getId();

    /**
     * Get Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get Mobile Number
     *
     * @return string|null
     */
    public function getMobileNumber();

    /**
     * Get Message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Get Product Sku
     *
     * @return string
     */
    public function getSku();

    /**
     * Get Display in front setting
     *
     * @return boolean|null
     */
    public function getDisplayFront();

    /**
     * Get Admin message
     *
     * @return string|null
     */
    public function getAdminMessage();

    /**
     * Get Satus
     *
     * @return boolean|null
     */
    public function getStatus();

    /**
     * Set ID
     *
     * @param int $id
     * @return InquiryInterface
     */
    public function setId($id);

    /**
     * Set Name
     *
     * @param string $name
     * @return InquiryInterface
     */
    public function setName($name);

    /**
     * Set Mobile Number
     *
     * @param string $mobile_number
     * @return InquiryInterface
     */
    public function setMobileNumber($mobile_number);

    /**
     * Set message
     *
     * @param string $message
     * @return InquiryInterface
     */
    public function setMessage($message);

    /**
     * Set Email
     *
     * @param string $email
     * @return InquiryInterface
     */
    public function setEmail($email);

    /**
     * Set Product Sku
     *
     * @param string $sku
     * @return InquiryInterface
     */
    public function setSku($sku);

    /**
     * Set Display in front setting
     *
     * @param bool|int $display_front
     * @return InquiryInterface
     */
    public function setDisplayFront($display_front);

    /**
     * Set Admin Message
     *
     * @param string $admin_message
     * @return InquiryInterface
     */
    public function setAdminMessage($admin_message);

    /**
     * Set Status
     *
     * @param bool|int $status
     * @return InquiryInterface
     */
    public function setStatus($status);
}
