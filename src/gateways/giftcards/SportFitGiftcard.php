<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\giftcards;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class SportFitGiftcard
 * @package multisafepay\multisafepay\gateways\giftcards
 */
class SportFitGiftcard extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Sport & Fit');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'SPORTENFIT';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
