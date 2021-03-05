<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class WijncadeauGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class WijncadeauGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Wijncadeau');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'WIJNCADEAU';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
