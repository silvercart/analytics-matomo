<?php

namespace SilverCart\Matomo\Extensions\Pages;

use SilverCart\Model\Pages\ProductGroupHolder;
use SilverStripe\Core\Extension;

/**
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class ProductGroupPageControllerExtension extends Extension
{
    /**
     * Delimiter character(s) to use as product group title separation.
     *
     * @var string
     */
    private static $matomo_breadcrumb_delimiter = ' > ';

    /**
     * Adds te Matomo tracking code for product group or detail pages.
     * 
     * @param string $content Content to update.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public function updateFooterCustomHtmlContent(&$content)
    {
        $ctrl = $this->owner;
        /* @var $ctrl \SilverCart\Model\Pages\ProductGroupPageController */
        if ($ctrl->isProductDetailView()) {
            $content .= $ctrl->renderWith(self::class . "_Detail");
        } else {
            $content .= $ctrl->renderWith(self::class);
        }
    }
    
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
        $ctrl = $this->owner;
        /* @var $ctrl \SilverCart\Model\Pages\ProductGroupPageController */
        $items = $ctrl->data()->getBreadcrumbItems(20, ProductGroupHolder::class);
        $map   = $items->map('ID', 'Title')->toArray();
        if ($ctrl->isProductDetailView()) {
            array_pop($map);
        }
        return implode($ctrl->config()->get('matomo_breadcrumb_delimiter'), $map);
    }
}