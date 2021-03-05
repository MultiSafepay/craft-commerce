<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class FashiongiftcardGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class FashiongiftcardGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Fashiongiftcard');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'FASHIONGFT';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
