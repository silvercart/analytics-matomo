<?php

namespace SilverCart\Matomo\Extensions\Product;

use SilverCart\Matomo\Core\Matomo;
use SilverStripe\ORM\DataExtension;

/**
 * Product extension to add the Matomo tracking code after adding a product to
 * cart.
 *
 * @package SilverCart
 * @subpackage Subpackage
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class ProductExtension extends DataExtension
{
    /**
     * Enables the Matomo shopping cart tracking after addding a product to cart.
     * 
     * @param \SilverCart\Model\Order\ShoppingCartPosition $position      Position
     * @param bool                                         $isNewPosition Is new position?
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public function onAfterAddToCart($position, $isNewPosition)
    {
        Matomo::do_track_shopping_cart();
    }
}