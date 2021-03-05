<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class MastercardGateway
 * @package multisafepay\multisafepay\gateways
 */
class MastercardGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Mastercard');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'MASTERCARD';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
