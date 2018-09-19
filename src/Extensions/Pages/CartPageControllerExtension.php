<?php

namespace SilverCart\Matomo\Extensions\Pages;

use SilverCart\Matomo\Core\Matomo;
use SilverStripe\Core\Extension;

/**
 * CartPageController extension. Enables the Matomo shopping cart tracking code.
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class CartPageControllerExtension extends Extension
{
    /**
     * Enables the Matomo shopping cart tracking after initializing the cart
     * page.
     * 
     * @param array $data Submitted data
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public function onAfterInit()
    {
        Matomo::do_track_shopping_cart();
    }
}