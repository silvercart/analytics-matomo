<?php

namespace SilverCart\Matomo\Extensions\Config;

use SilverStripe\ORM\DataExtension;

/**
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Config
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 21.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SiteConfigExtension extends DataExtension
{
    /**
     * Removes the "_paq.push(['trackPageView'])" Javascript call out of the 
     * default Matomo tracking code to prevent multiple page tracking on product
     * group and detail pages, cart page and order thanks page since the 
     * eCommmerce tracking will add an own "_paq.push(['trackPageView'])" call 
     * after adding the eCommerce related data.
     * The "_paq.push(['trackPageView'])" call will happen independent of any
     * eCommerce related action.
     * 
     * @param string $matomoTrackingCode The Matomo tracking code to update
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.09.2018
     */
    public function updateMatomoTrackingCode(&$matomoTrackingCode)
    {
        $matomoTrackingCode = str_replace("_paq.push(['trackPageView']);", "", $matomoTrackingCode);
        $matomoTrackingCode = str_replace("_paq.push(['trackPageView'])", "",  $matomoTrackingCode);
    }
}