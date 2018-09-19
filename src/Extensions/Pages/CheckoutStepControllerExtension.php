<?php

namespace SilverCart\Matomo\Extensions\Pages;

use SilverCart\Matomo\Core\Matomo;
use SilverStripe\Core\Extension;

/**
 * CheckoutStepController extension. Enables the Matomo order tracking code if
 * necessary.
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class CheckoutStepControllerExtension extends Extension
{
    /**
     * Enables the Matomo order tracking code before rendering the thanks action.
     * 
     * @param \SilverCart\Model\Order\Order           $order         Order
     * @param \SilverCart\Model\Payment\PaymentMethod $paymentMethod Payment method
     * @param array                                   $checkoutData  Checkout data
     */
    public function onBeforeRenderThanks($order, $paymentMethod, $checkoutData)
    {
        Matomo::do_track_order($order);
    }
}