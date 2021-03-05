<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class BabyCadeaubonGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class BabyCadeaubonGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Baby Cadeaubon');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'BABYCAD';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
