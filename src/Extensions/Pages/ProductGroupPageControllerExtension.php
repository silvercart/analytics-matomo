<?php

namespace SilverCart\Matomo\Extensions\Pages;

use SilverCart\Matomo\Core\Matomo;
use SilverStripe\Core\Extension;

/**
 * ProductGroupPageController extension. Enables the Matomo product group or 
 * detail view tracking code.
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
     * Adds te Matomo tracking code for product group pages if necessary.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public function onAfterInit()
    {
        $ctrl = $this->owner;
        /* @var $ctrl \SilverCart\Model\Pages\ProductGroupPageController */
        if (!$ctrl->isProductDetailView()) {
            Matomo::do_track_product_group_view($ctrl->data());
        }
    }
    
    /**
     * Adds te Matomo tracking code for product detail pages if necessary.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public function onBeforeRenderProductDetailView()
    {
        $ctrl = $this->owner;
        /* @var $ctrl \SilverCart\Model\Pages\ProductGroupPageController */
        if ($ctrl->isProductDetailView()) {
            Matomo::do_track_product_detail_view($ctrl->getProduct());
        }
    }
}