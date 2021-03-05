<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class GivaCardGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class GivaCardGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'GivaCard');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'GIVACARD';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
