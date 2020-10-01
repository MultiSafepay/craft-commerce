<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class SantanderGateway
 * @package multisafepay\multisafepay\gateways
 */
class SantanderGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Santander Consumer Finance | Pay per Month');
    }

    /**
     * @return string
     */
    public static function getGatewayCode(): string
    {
        return 'SANTANDER';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'redirect';
    }
}
