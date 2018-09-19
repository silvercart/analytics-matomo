<?php

namespace SilverCart\Matomo\Extensions\Pages;

use SilverCart\Matomo\Core\Matomo;
use SilverStripe\Core\Extension;

/**
 * PageController extension. Adds the Matomo eCommerce tracking code if necessary.
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class PageControllerExtension extends Extension
{
    /**
     * Adds the Matomo eCommerce tracking code if necessary.
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
        $content .= Matomo::get_ecommerce_tracking_code();
        Matomo::reset();
    }
}