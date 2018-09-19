<?php

namespace SilverCart\Matomo\Extensions\Pages;

use SilverCart\Model\Pages\ProductGroupHolder;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataExtension;

/**
 * ProductGroupPage extension. Adds a special Matomo breadcrumb title to 
 * provide unique product group names to track.
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class ProductGroupPageExtension extends DataExtension
{
    /**
     * Delimiter character(s) to use as product group title separation.
     *
     * @var string
     */
    private static $matomo_breadcrumb_delimiter = ' > ';
    
    /**
     * Returns the title including the parent product group titles to have a 
     * unique Matomo reference.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public function MatomoBreadcrumbTitle()
    {
        $group = $this->owner;
        $ctrl  = Controller::curr();
        /* @var $group \SilverCart\Model\Pages\ProductGroupPage */
        /* @var $ctrl \SilverCart\Model\Pages\ProductGroupPageController */
        $items = $group->getBreadcrumbItems(20, ProductGroupHolder::class);
        $map   = $items->map('ID', 'Title')->toArray();
        if ($ctrl->hasMethod('isProductDetailView')
         && $ctrl->isProductDetailView()) {
            array_pop($map);
        }
        return implode($group->config()->get('matomo_breadcrumb_delimiter'), $map);
    }
}