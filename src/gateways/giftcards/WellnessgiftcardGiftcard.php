<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class WellnessgiftcardGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class WellnessgiftcardGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Wellness gift card');
    }

    /**
     * @return string
     */
    public static function getGatewayCode(): string
    {
        return 'WELLNESSGIFTCARD';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'redirect';
    }
}
