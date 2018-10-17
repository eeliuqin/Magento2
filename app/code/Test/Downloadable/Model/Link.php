<?php

namespace Test\Downloadable\Model;

use Magento\Downloadable\Api\Data\LinkInterface;
use Magento\Downloadable\Model\ResourceModel\Link as Resource;

/**
 * Downloadable link model
 *
 */
class Link extends \Magento\Downloadable\Model\Link
{
    const LINK_VISIBLE_YES = 1;
    
    const LINK_VISIBLE_NO = 0;

    const KEY_IS_VISIBLE = 'is_visible';

    public function getIsVisible()
    {
        return $this->getData(self::KEY_IS_VISIBLE);
    }

    public function setIsVisible($isVisible)
    {
        return $this->setData(self::KEY_IS_VISIBLE, $isVisible);
    }
}
