<?php
/**
 * Override Magento_Downloadable to add 'Is Visible' column
 */
namespace Test\Downloadable\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Downloadable\Model\Product\Type;
use Magento\Downloadable\Model\Source\TypeUpload;
use Magento\Downloadable\Model\Source\Shareable;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\DynamicRows;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\Form;
use Test\Downloadable\Model\Source\Visible;

/**
 * Class adds a grid with links
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Links extends \Magento\Downloadable\Ui\DataProvider\Product\Form\Modifier\Links
{
    /** 
     * @var Visible
     */
    protected $visible;

    /**
     * @param LocatorInterface $locator
     * @param StoreManagerInterface $storeManager
     * @param ArrayManager $arrayManager
     * @param UrlInterface $urlBuilder
     * @param TypeUpload $typeUpload
     * @param Shareable $shareable
     * @param Data\Links $linksData
     * @param Visible $visible
     */
    public function __construct(
        LocatorInterface $locator,
        StoreManagerInterface $storeManager,
        ArrayManager $arrayManager,
        UrlInterface $urlBuilder,
        TypeUpload $typeUpload,
        Shareable $shareable,
        Data\Links $linksData,
		Visible $visible
    ) {
        parent::__construct($locator, $storeManager, $arrayManager, $urlBuilder, $typeUpload, $shareable, $linksData);
        $this->visible = $visible;
    }

    /**
     * @return array
     */
    protected function getRecord()
    {
        $record['arguments']['data']['config'] = [
            'componentType' => Container::NAME,
            'isTemplate' => true,
            'is_collection' => true,
            'component' => 'Magento_Ui/js/dynamic-rows/record',
            'dataScope' => '',
        ];
        $recordPosition['arguments']['data']['config'] = [
            'componentType' => Form\Field::NAME,
            'formElement' => Form\Element\Input::NAME,
            'dataType' => Form\Element\DataType\Number::NAME,
            'dataScope' => 'sort_order',
            'visible' => false,
        ];
        $recordActionDelete['arguments']['data']['config'] = [
            'label' => null,
            'componentType' => 'actionDelete',
            'fit' => true,
        ];

        return $this->arrayManager->set(
            'children',
            $record,
            [
                'container_link_title' => $this->getTitleColumn(),
                'container_link_price' => $this->getPriceColumn(),
                'container_file' => $this->getFileColumn(),
                'container_sample' => $this->getSampleColumn(),
                'is_shareable' => $this->getShareableColumn(),
                'is_visible' => $this->getIsVisibleColumn(), //add is_visible column
                'max_downloads' => $this->getMaxDownloadsColumn(),
                'position' => $recordPosition,
                'action_delete' => $recordActionDelete,
            ]
        );
    }


    /**
     * @return array
     */
    protected function getIsVisibleColumn()
    {
        $isVisibleField['arguments']['data']['config'] = [
            'label' => __('Is Visible'),
            'formElement' => Form\Element\Select::NAME,
            'componentType' => Form\Field::NAME,
            'dataType' => Form\Element\DataType\Number::NAME,
            'dataScope' => 'is_visible',
            'options' => $this->visible->toOptionArray(),
        ];

        return $isVisibleField;
    }
}
