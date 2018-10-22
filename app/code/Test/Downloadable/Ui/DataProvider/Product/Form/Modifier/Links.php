<?php
/**
 * add 'Is Visible'
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
class Links extends AbstractModifier 
{

    /** 
     * @var Visible
     */
	protected $visible;

    /**
     * @param Visible $visible
     */
    public function __construct(
		Visible $visible
    ) {
	$this->visible = $visible;
    }

    public function modifyMeta(array $meta)
    {
        $meta['downloadable']['children']['container_links']['children']['link']['children']['record']['children']['is_visible'] = [
			'arguments' => [
				'data' => [
					'config' => [
						'label' => __('Is Visible'),
						'formElement' => Form\Element\Select::NAME,
						'componentType' => Form\Field::NAME,
						'dataType' => Form\Element\DataType\Number::NAME,
						'options' => $this->visible->toOptionArray(), 
					]
				]
			] 
		];
        return $meta;
	}

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }
}
