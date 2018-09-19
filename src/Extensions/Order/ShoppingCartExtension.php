<?php

namespace SilverCart\Matomo\Extensions\Order;

use SilverCart\Matomo\Core\Matomo;
use SilverStripe\ORM\DataExtension;

/**
 * ShoppingCart extension to add the Matomo tracking code after removing a
 * product from cart.
 *
 * @package SilverCart
 * @subpackage Subpackage
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class ShoppingCartExtension extends DataExtension
{
    /**
     * Enables the Matomo shopping cart tracking after removing a product from
     * cart.
     * 
     * @param array $data Submitted data
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public function onAfterRemoveFromCart($data)
    {
        Matomo::do_track_shopping_cart();
    }
}