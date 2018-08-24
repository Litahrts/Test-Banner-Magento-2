<?php

namespace Custom\Banner\Controller\Adminhtml\Banner;

use Custom\Banner\Helper\Image;
use Magento\Backend\App\Action;

class Save extends Action
{

    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var $model Custom\Banner\Model\Banner */
            $model = $this->_objectManager->create('Custom\Banner\Model\Banner');

            $id = $this->getRequest()->getParam('banner_id');
            if ($id) {
                $model->load($id);
            }

            $image = $this->getRequest()->getFiles('image');
            $fileName = ($image && array_key_exists('name', $image)) ? $image['name'] : null;

            /** @var  $imageHelper Image */
            $newImage = $this->_objectManager->get('Custom\Banner\Helper\Image')->storeBannerImage($image, $fileName);
            $data['image'] = $newImage ? $newImage : $data['image']['value'];
            $model->setData($data);

            $this->_eventManager->dispatch(
                'banner_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();

                $this->messageManager->addSuccess(__('You saved this Banner.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Custom_Banner::save');
    }
}