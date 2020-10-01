<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class GiropayGateway
 * @package multisafepay\multisafepay\gateways
 */
class GiropayGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Giropay');
    }

    /**
     * @return string
     */
    public static function getGatewayCode(): string
    {
        return 'GIROPAY';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'redirect';
    }
}
