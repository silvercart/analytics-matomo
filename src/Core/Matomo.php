<?php

namespace SilverCart\Matomo\Core;

use SilverCart\Dev\Tools;
use SilverCart\Model\Customer\Customer;
use SilverStripe\View\ViewableData;

/**
 * Main Matomo eCommerce handler.
 * Handles the eCommerce tracking code parts to render and generates the final
 * code.
 *
 * @package SilverCart
 * @subpackage Subpackage
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class Matomo
{
    const SESSION_KEY            = 'SilverCart.Matomo';
    const SESSION_KEY_TRACK_CART = 'SilverCart.Matomo.TrackCart';
    
    /**
     *
     * @var bool
     */
    protected static $track_shopping_cart = null;
    
    /**
     * Enables the shopping cart tracking.
     * 
     * @return void
     */
    public static function do_track_shopping_cart()
    {
        self::set_track_shopping_cart(true);
    }
    
    /**
     * Returns whether to track the shopping cart or not.
     * Alias for self::get_track_shopping_cart().
     * 
     * @return bool
     */
    public static function track_shopping_cart()
    {
        return self::get_track_shopping_cart();
    }
    
    /**
     * Returns whether to track the shopping cart or not.
     * 
     * @return bool
     */
    public static function get_track_shopping_cart()
    {
        if (is_null(self::$track_shopping_cart)) {
            self::$track_shopping_cart = (bool) Tools::Session()->get(self::SESSION_KEY_TRACK_CART);
        }
        return self::$track_shopping_cart;
    }

    /**
     * Sets whether to track the shopping cart or not.
     * 
     * @param bool $track_shopping_cart Track shopping cart?
     * 
     * @return void
     */
    public static function set_track_shopping_cart($track_shopping_cart)
    {
        Tools::Session()->set(self::SESSION_KEY_TRACK_CART, $track_shopping_cart);
        Tools::saveSession();
        self::$track_shopping_cart = $track_shopping_cart;
    }
    
    /**
     * Resets the tracking settings.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.09.2018
     */
    public static function reset()
    {
        self::set_track_shopping_cart(false);
    }
    
    /**
     * Returns the Matomo eCommerce tracking code.
     * 
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public static function get_ecommerce_tracking_code()
    {
        $customer     = Customer::currentUser();
        $viewable     = ViewableData::singleton();
        $trackingCode = '';
        if (self::track_shopping_cart()) {
            $trackingCode .= $viewable->customise([
                'Cart' => $customer->getCart(),
            ])->renderWith(self::class . '_TrackCart');
        }
        
        return $viewable->customise([
            'TrackingCode' => $trackingCode,
        ])->renderWith(self::class . '_TrackPageView');
    }
}