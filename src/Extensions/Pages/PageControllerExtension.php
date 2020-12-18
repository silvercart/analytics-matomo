<?php

namespace SilverCart\Matomo\Extensions\Pages;

use SilverCart\Matomo\Core\Matomo;
use SilverCart\Matomo\Extensions\Control\ControllerExtension;

/**
 * PageController extension. Adds the Matomo eCommerce tracking code if necessary.
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 19.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 * 
 * @property \SilverCart\Model\Pages\PageController $owner Owner
 */
class PageControllerExtension extends ControllerExtension
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
    public function updateFooterCustomHtmlContent(&$content) : void
    {
        $content .= Matomo::get_ecommerce_tracking_code();
        Matomo::reset();
    }
}