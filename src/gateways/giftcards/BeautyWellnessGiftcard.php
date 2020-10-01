<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class BeautyWellnessGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class BeautyWellnessGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Beauty & Wellness');
    }

    /**
     * @return string
     */
    public static function getGatewayCode(): string
    {
        return 'BEAUTYWELL';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'redirect';
    }
}
