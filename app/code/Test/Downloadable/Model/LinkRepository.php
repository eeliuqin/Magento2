<?php
/**
 * Override Magento_Downloadable to add is_visible to link
 */
namespace Test\Downloadable\Model;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Downloadable\Api\Data\LinkInterface;
use Magento\Downloadable\Model\Product\Type;
use Magento\Downloadable\Api\Data\File\ContentUploaderInterface;
use Magento\Downloadable\Model\Product\TypeHandler\Link as LinkHandler;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Class LinkRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LinkRepository extends \Magento\Downloadable\Model\LinkRepository
{

    /** 
     * @var LinkHandler
     */
    private $linkTypeHandler;

    /**
     * Build a link data object
     *
     * @param \Magento\Downloadable\Model\Link $resourceData
     * @return \Magento\Downloadable\Model\Link
     */
    protected function buildLink($resourceData)
    {
        /** @var \Magento\Downloadable\Model\Link $link */
        $link = $this->linkDataObjectFactory->create();
        $this->setBasicFields($resourceData, $link);
        $link->setPrice($resourceData->getPrice());
        $link->setNumberOfDownloads($resourceData->getNumberOfDownloads());
        $link->setIsVisible($resourceData->getIsVisible()); // add is_visible to link
        $link->setIsShareable($resourceData->getIsShareable());
        $link->setLinkType($resourceData->getLinkType());
        $link->setLinkFile($resourceData->getLinkFile());
        $link->setLinkUrl($resourceData->getLinkUrl());

        return $link;
    }

    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param LinkInterface $link
     * @param bool $isGlobalScopeContent
     * @return int
     */
    protected function saveLink(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        LinkInterface $link,
        $isGlobalScopeContent
    ) {
        $linkData = [
            'link_id' => (int)$link->getid(),
            'is_delete' => 0,
            'type' => $link->getLinkType(),
            'sort_order' => $link->getSortOrder(),
            'title' => $link->getTitle(),
            'price' => $link->getPrice(),
            'number_of_downloads' => $link->getNumberOfDownloads(),
            'is_shareable' => $link->getIsShareable(),
            'is_visible' => $link->getIsVisible() // add is_visible to link
        ];

        if ($link->getLinkType() == 'file' && $link->getLinkFile() === null) {
            $linkData['file'] = $this->jsonEncoder->encode(
                [
                    $this->fileContentUploader->upload($link->getLinkFileContent(), 'link_file'),
                ]
            );
        } elseif ($link->getLinkType() === 'url') {
            $linkData['link_url'] = $link->getLinkUrl();
        } else {
            //existing link file
            $linkData['file'] = $this->jsonEncoder->encode(
                [
                    [
                        'file' => $link->getLinkFile(),
                        'status' => 'old',
                    ]
                ]
            );
        }

        if ($link->getSampleType() == 'file') {
            $linkData['sample']['type'] = 'file';
            if ($link->getSampleFile() === null) {
                $fileData = [
                    $this->fileContentUploader->upload($link->getSampleFileContent(), 'link_sample_file'),
                ];
            } else {
                $fileData = [
                    [
                        'file' => $link->getSampleFile(),
                        'status' => 'old',
                    ]
                ];
            }
            $linkData['sample']['file'] = $this->jsonEncoder->encode($fileData);
        } elseif ($link->getSampleType() == 'url') {
            $linkData['sample']['type'] = 'url';
            $linkData['sample']['url'] = $link->getSampleUrl();
        }

        $downloadableData = ['link' => [$linkData]];
        if ($isGlobalScopeContent) {
            $product->setStoreId(0);
        }
        $this->getLinkTypeHandler()->save($product, $downloadableData);
        return $product->getLastAddedLinkId();
    }

    /** 
     * Get LinkTypeHandler  instance
     *
     * @deprecated 100.1.0 MAGETWO-52273
     * @return LinkHandler
     */
    private function getLinkTypeHandler()
    {   
        if (!$this->linkTypeHandler) {
            $this->linkTypeHandler = ObjectManager::getInstance()->get(LinkHandler::class);
        }   

        return $this->linkTypeHandler;
    }   

}
