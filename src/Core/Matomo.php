<?php

namespace SilverCart\Matomo\Core;

use SilverCart\Dev\Tools;
use SilverCart\Model\Customer\Customer;
use SilverCart\Model\Order\Order;
use SilverCart\Model\Pages\ProductGroupPage;
use SilverCart\Model\Pages\Page;
use SilverCart\Model\Product\Product;
use SilverStripe\Security\Member;
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
    const SESSION_KEY                      = 'SilverCart.Matomo';
    const SESSION_KEY_ORDER_ID             = 'SilverCart.Matomo.OrderID';
    const SESSION_KEY_PRODUCT_ID           = 'SilverCart.Matomo.ProductID';
    const SESSION_KEY_PRODUCT_GROUP_ID     = 'SilverCart.Matomo.ProductGroupID';
    const SESSION_KEY_TRACK_CART           = 'SilverCart.Matomo.TrackCart';
    const SESSION_KEY_TRACK_ORDER          = 'SilverCart.Matomo.TrackOrder';
    const SESSION_KEY_TRACK_PRODUCT_DETAIL = 'SilverCart.Matomo.TrackProductDetail';
    const SESSION_KEY_TRACK_PRODUCT_GROUP  = 'SilverCart.Matomo.TrackProductGroup';
    
    /**
     * Order context to track.
     *
     * @var Order
     */
    protected static $order = null;
    /**
     * Product context to track detail page view for.
     *
     * @var Product
     */
    protected static $product = null;
    /**
     * Product group context to track detail page view for.
     *
     * @var Page
     */
    protected static $product_group = null;
    /**
     * Determines whether to track an order for the current request or not.
     *
     * @var bool
     */
    protected static $track_order = null;
    /**
     * Determines whether to track product detail view for the current request 
     * or not.
     *
     * @var bool
     */
    protected static $track_product_detail_view = null;
    /**
     * Determines whether to track product group view for the current request or
     * not.
     *
     * @var bool
     */
    protected static $track_product_group_view = null;
    /**
     * Determines whether to track the shopping cart for the current request or
     * not.
     *
     * @var bool
     */
    protected static $track_shopping_cart = null;
    
    /**
     * Returns the order to track.
     * 
     * @return Order
     */
    public static function get_order()
    {
        if (is_null(self::$order)) {
            $orderID = Tools::Session()->get(self::SESSION_KEY_ORDER_ID);
            if (is_numeric($orderID)) {
                self::$order = Order::get()->byID((int) $orderID);
            }
        }
        return self::$order;
    }
    
    /**
     * Sets the order to track.
     * 
     * @param Order $order Order
     * 
     * @return void
     */
    public static function set_order(Order $order = null)
    {
        $orderID = 0;
        if ($order instanceof Order
         && $order->exists()
        ) {
            $orderID = $order->ID;
        }
        Tools::Session()->set(self::SESSION_KEY_ORDER_ID, $orderID);
        Tools::saveSession();
        self::$order = $order;
    }
    
    /**
     * Returns the product to track detail view for.
     * 
     * @return Product
     */
    public static function get_product()
    {
        if (is_null(self::$product)) {
            $productID = Tools::Session()->get(self::SESSION_KEY_PRODUCT_ID);
            if (is_numeric($productID)) {
                self::$product = Product::get()->byID((int) $productID);
            }
        }
        return self::$product;
    }
    
    /**
     * Sets the product to track detail view for.
     * 
     * @param Product $product Product
     * 
     * @return void
     */
    public static function set_product(Product $product = null)
    {
        $productID = 0;
        if ($product instanceof Product
         && $product->exists()
        ) {
            $productID = $product->ID;
        }
        Tools::Session()->set(self::SESSION_KEY_PRODUCT_ID, $productID);
        Tools::saveSession();
        self::$product = $product;
    }
    
    /**
     * Returns the product group to track detail view for.
     * 
     * @return Page
     */
    public static function get_product_group()
    {
        if (is_null(self::$product_group)) {
            $productGroupID = Tools::Session()->get(self::SESSION_KEY_PRODUCT_GROUP_ID);
            if (is_numeric($productGroupID)) {
                self::$product_group = Page::get()->byID((int) $productGroupID);
            }
        }
        return self::$product_group;
    }
    
    /**
     * Sets the product group to track detail view for.
     * 
     * @param Page $product_group Product group
     * 
     * @return void
     */
    public static function set_product_group(Page $product_group = null)
    {
        $productGroupID = 0;
        if ($product_group instanceof Page
         && $product_group->exists()
        ) {
            $productGroupID = $product_group->ID;
        }
        Tools::Session()->set(self::SESSION_KEY_PRODUCT_GROUP_ID, $productGroupID);
        Tools::saveSession();
        self::$product_group = $product_group;
    }
    
    /**
     * Enables the order tracking.
     * 
     * @param Order $order Order to track
     * 
     * @return void
     */
    public static function do_track_order(Order $order = null)
    {
        self::set_track_order(true, $order);
    }
    
    /**
     * Returns whether to track the order or not.
     * Alias for self::get_track_order().
     * 
     * @return bool
     */
    public static function track_order()
    {
        return self::get_track_order();
    }
    
    /**
     * Returns whether to track the order or not.
     * 
     * @return bool
     */
    public static function get_track_order()
    {
        if (is_null(self::$track_order)) {
            self::$track_order = (bool) Tools::Session()->get(self::SESSION_KEY_TRACK_ORDER);
        }
        return self::$track_order;
    }

    /**
     * Sets whether to track the order or not.
     * 
     * @param bool  $track_order Track order?
     * @param Order $order       Order to track
     * 
     * @return void
     */
    public static function set_track_order($track_order, Order $order = null)
    {
        Tools::Session()->set(self::SESSION_KEY_TRACK_ORDER, $track_order);
        Tools::saveSession();
        self::$track_order = $track_order;
        self::set_order($order);
    }
    
    /**
     * Enables the product detail view tracking.
     * 
     * @param Product $product Product to track detail view for
     * 
     * @return void
     */
    public static function do_track_product_detail_view(Product $product = null)
    {
        self::set_track_product_detail_view(true, $product);
    }
    
    /**
     * Returns whether to track the product detail view or not.
     * Alias for self::get_track_product_detail_view().
     * 
     * @return bool
     */
    public static function track_product_detail_view()
    {
        return self::get_track_product_detail_view();
    }
    
    /**
     * Returns whether to track the product detail view or not.
     * 
     * @return bool
     */
    public static function get_track_product_detail_view()
    {
        if (is_null(self::$track_product_detail_view)) {
            self::$track_product_detail_view = (bool) Tools::Session()->get(self::SESSION_KEY_TRACK_PRODUCT_DETAIL);
        }
        return self::$track_product_detail_view;
    }

    /**
     * Sets whether to track the product detail view or not.
     * 
     * @param bool    $track_product_detail_view Track product detail view?
     * @param Product $product                   Product to track detail view for
     * 
     * @return void
     */
    public static function set_track_product_detail_view($track_product_detail_view, Product $product = null)
    {
        Tools::Session()->set(self::SESSION_KEY_TRACK_PRODUCT_DETAIL, $track_product_detail_view);
        Tools::saveSession();
        self::$track_product_detail_view = $track_product_detail_view;
        self::set_product($product);
    }
    
    /**
     * Enables the product group view tracking.
     * 
     * @param Page $product_group Product group
     * 
     * @return void
     */
    public static function do_track_product_group_view(Page $product_group = null)
    {
        self::set_track_product_group_view(true, $product_group);
    }
    
    /**
     * Returns whether to track the product group view or not.
     * Alias for self::get_track_product_group_view().
     * 
     * @return bool
     */
    public static function track_product_group_view()
    {
        return self::get_track_product_group_view();
    }
    
    /**
     * Returns whether to track the product group view or not.
     * 
     * @return bool
     */
    public static function get_track_product_group_view()
    {
        if (is_null(self::$track_product_group_view)) {
            self::$track_product_group_view = (bool) Tools::Session()->get(self::SESSION_KEY_TRACK_PRODUCT_GROUP);
        }
        return self::$track_product_group_view;
    }

    /**
     * Sets whether to track the product group view or not.
     * 
     * @param bool $track_product_group_view Track product group view?
     * @param Page $product_group            Product group
     * 
     * @return void
     */
    public static function set_track_product_group_view($track_product_group_view, Page $product_group = null)
    {
        Tools::Session()->set(self::SESSION_KEY_TRACK_PRODUCT_GROUP, $track_product_group_view);
        Tools::saveSession();
        self::$track_product_group_view = $track_product_group_view;
        self::set_product_group($product_group);
    }
    
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
        self::set_track_order(false);
        self::set_track_product_detail_view(false);
        self::set_track_product_group_view(false);
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
        
        if (self::track_shopping_cart()
         && $customer instanceof Member
         && $customer->exists()) {
            $trackingCode .= $viewable->customise([
                'Cart' => $customer->getCart(),
            ])->renderWith(self::class . '_TrackCart');
        }
        if (self::track_order()) {
            $trackingCode .= $viewable->customise([
                'Order' => self::get_order(),
            ])->renderWith(self::class . '_TrackOrder');
        }
        if (self::track_product_detail_view()) {
            $trackingCode .= $viewable->customise([
                'Product' => self::get_product(),
            ])->renderWith(self::class . '_TrackProductView');
        }
        if (self::track_product_group_view()) {
            $trackingCode .= $viewable->customise([
                'ProductGroup' => self::get_product_group(),
            ])->renderWith(self::class . '_TrackProductGroupView');
        }
        
        return $viewable->customise([
            'TrackingCode' => $trackingCode,
        ])->renderWith(self::class . '_TrackPageView');
    }
}