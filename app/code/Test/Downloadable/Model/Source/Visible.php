<?php

namespace Test\Downloadable\Model\Source;

use Test\Downloadable\Model\Link;

/**
 * Visible source class
 */
class Visible implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => Link::LINK_VISIBLE_YES, 'label' => __('Yes')],
            ['value' => Link::LINK_VISIBLE_NO, 'label' => __('No')]
        ];
    }
}
