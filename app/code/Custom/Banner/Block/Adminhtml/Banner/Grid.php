<?php
namespace Custom\Banner\Block\Adminhtml\Banner;

class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{

    protected function _construct()
    {
        parent::_construct();
        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'Custom_Banner';
        $this->_headerText = __('Banners');
        $this->_addButtonLabel = __('Create New Banner');
    }
}