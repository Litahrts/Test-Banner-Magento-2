<?php

namespace Custom\Banner\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ObjectManager;
use Magento\MediaStorage\Model\File\Uploader;

class Image extends AbstractHelper
{
    public function storeBannerImage($image, $fileName)
    {
        if ($image && $fileName) {
            /** @var \Magento\Framework\ObjectManagerInterface $uploader */
            $objectManager = ObjectManager::getInstance();
            try {
                /** @var $uploader Uploader */
                $uploader = $objectManager->create(
                    'Magento\MediaStorage\Model\File\Uploader',
                    ['fileId' => 'image']
                );
                $uploader
                    ->setAllowedExtensions(['jpg', 'jpeg', 'png'])
                    ->setAllowRenameFiles(true)
                    ->setFilesDispersion(true)
                    ->setAllowCreateFolders(true);

                /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                $mediaDirectory = $objectManager->get('Magento\Framework\Filesystem')
                    ->getDirectoryRead(DirectoryList::MEDIA);
                $result = $uploader->save($mediaDirectory->getAbsolutePath('banners'))
                ;
                return 'banners' . $result['file'];
            } catch (\Exception $e) {
                return null;
            }
        }
    }
}