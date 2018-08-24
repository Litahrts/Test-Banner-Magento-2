<?php
namespace Custom\Banner\Block;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\View\Element\Template;

class Banner extends \Magento\Framework\View\Element\Template
{

    protected $context;

    public function __construct(Template\Context $context, array $data = [])
    {
        $this->context = $context;
        parent::__construct($context, $data);
    }

//    public function getCategoriesList()
//    {
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $categoryCollection = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
//        $categories = $categoryCollection->create();
//        $categories->addAttributeToSelect(['name']);
//
//        return $categories;
//    }
    public function getCurrentBanner()
    {
        $id = $this->context->getRequest()->getParam('id');

        if ($id) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            /** @var \Custom\Banner\Model\ResourceModel\Banner\Collection  $categoryCollection */
            $bannersCollection = $objectManager->get('\Custom\Banner\Model\ResourceModel\Banner\Collection');
            $banner = $bannersCollection
                ->addFieldToFilter('status', ['eq' => 1])
                ->addFieldToFilter('category_id', ['eq' => $id]);
            $banner->getSelect()->orderRand();
            return $banner->getLastItem();
        }

        return [];
    }

    public function getMediaUrl()
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => DirectoryList::MEDIA]);
    }
}