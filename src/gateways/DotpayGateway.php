<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class DotpayGateway
 * @package multisafepay\multisafepay\gateways
 */
class DotpayGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Dotpay');
    }

    /**
     * @return string
     */
    public static function getGatewayCode(): string
    {
        return 'DOTPAY';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'direct';
    }
}
