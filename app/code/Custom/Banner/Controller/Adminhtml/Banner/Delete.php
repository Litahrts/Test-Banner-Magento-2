<?php

namespace Custom\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\File\UploaderFactory;

class Delete extends Action
{

    protected $_fileUploaderFactory;

    public function __construct(
        Action\Context $context,
        UploaderFactory $fileUploaderFactory
    ) {
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
    }


    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Custom_Banner::delete');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $id = $this->getRequest()->getParam('id');
        try {
            $model = $this->_objectManager->create('Custom\Banner\Model\Banner');
            $model->load($id);
            $model->delete();

            $this->messageManager->addSuccess(__('Success delete'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->messageManager->addError(__('This banner no longer exists.'));

            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }
        $model = $this->_objectManager->create('Custom\Banner\Model\Banner');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
            $model->delete();
        }
        return $resultRedirect->setPath('*/*/');
    }
}