<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class WebshopGiftcardGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class WebshopGiftcardGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Webshop Giftcard');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'WEBSHOPGIFTCARD';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
