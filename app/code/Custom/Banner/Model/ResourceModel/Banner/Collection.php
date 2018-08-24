<?php
namespace Custom\BannerModel\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'banner_id';
    protected $_eventPrefix = 'custom_banner_collection';
    protected $_eventObject = 'banner_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Custom\Banner\Model\Banner', 'Custom\Banner\Model\ResourceModel\Banner');
    }

}
