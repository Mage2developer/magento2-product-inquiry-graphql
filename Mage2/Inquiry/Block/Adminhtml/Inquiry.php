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

namespace Mage2\Inquiry\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Inquiry
 *
 * @package Mage2\Inquiry\Block\Adminhtml
 */
class Inquiry extends Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup     = 'Mage2_Inquiry';
        $this->_controller     = 'adminhtml_block';
        $this->_headerText     = __('Product Inquiry');
        $this->_addButtonLabel = __('Add New Inquiry');
        parent::_construct();
    }
}
