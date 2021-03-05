<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class PayAfterDeliveryGateway
 * @package multisafepay\multisafepay\gateways
 */
class PayAfterDeliveryGateway extends BaseGateway
{
    const SUPPORTS_REFUND = false;
    const SUPPORTS_PARTIAL_REFUND = false;

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Pay After Delivery');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'PAYAFTER';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }
}
