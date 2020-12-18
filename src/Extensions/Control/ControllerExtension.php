<?php

namespace SilverCart\Matomo\Extensions\Control;

use SilverCart\Matomo\Core\Matomo;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBHTMLText;

/**
 * Controller extension. Adds the Matomo eCommerce tracking code if necessary.
 * 
 * @package SilverCart
 * @subpackage Matomo\Extensions\Control
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 17.12.2020
 * @copyright 2020 pixeltricks GmbH
 * @license see license file in modules root directory
 * 
 * @property \SilverStripe\Control\Controller $owner Owner
 */
class ControllerExtension extends Extension
{
    /**
     * Returns the Matomo eCommerce tracking code as DBHTMLText.
     * 
     * @return DBHTMLText
     */
    public function LoadMatomoEcommerceTrackingCode() : DBHTMLText
    {
        $code = DBHTMLText::create()->setValue(Matomo::get_ecommerce_tracking_code());
        Matomo::reset();
        return $code;
    }
}