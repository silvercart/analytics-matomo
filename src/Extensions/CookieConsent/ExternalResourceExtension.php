<?php

namespace SilverCart\Matomo\Extensions\CookieConsent;

use Broarm\CookieConsent\CookieConsent;
use SilverCart\Matomo\Core\Matomo;
use SilverCart\Model\CookieConsent\ExternalResource;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfigLeftAndMain;

/**
 * 
 * @package SilverCart
 * @subpackage Matomo_Extensions_Config
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 21.09.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 * 
 * @property ExternalResource $owner Owner
 */
class ExternalResourceExtension extends DataExtension
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
     * @param string &$code The code to update
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.09.2018
     */
    public function updateCode(string &$code) : void
    {
        if (Controller::curr() instanceof SiteConfigLeftAndMain) {
            return;
        }
        if ($this->owner->Name === ExternalResource::RESOURCE_MATOMO_TRACKING_CODE) {
            $replacement = '';
            if (class_exists(CookieConsent::class)) {
                $cookieGroup = $this->owner->CookieGroup();
                /* @var $cookieGroup \Broarm\CookieConsent\Model\CookieGroup */
                if ($cookieGroup->exists()
                 && !CookieConsent::check($cookieGroup->ConfigName)
                ) {
                    $replacement = "_paq.push(['disableCookies']);";
                }
            }
            $code = str_replace("_paq.push(['trackPageView']);", $replacement, $code);
            $code = str_replace("_paq.push(['trackPageView'])", $replacement,  $code);
        }
    }
    
    /**
     * Matomo tracking can be used without cookies.
     * 
     * @return bool
     */
    public function updateCanBeRequiredWithoutCookies() : ?bool
    {
        return $this->owner->Name === ExternalResource::RESOURCE_MATOMO_TRACKING_CODE
            && Matomo::config()->enable_cookieless_tracking;
    }
}