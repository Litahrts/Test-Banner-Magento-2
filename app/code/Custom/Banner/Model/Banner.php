<?php
namespace Custom\Banner\Model;
class Banner extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'custom_banner';

    protected $_cacheTag = 'custom_banner';

    protected $_eventPrefix = 'custom_banner';

    protected function _construct()
    {
        $this->_init('Custom\Banner\Model\ResourceModel\Banner');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}