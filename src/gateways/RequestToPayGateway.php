<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class RequestToPayGateway
 * @package multisafepay\multisafepay\gateways
 */
class RequestToPayGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Deutsche Bank Request to Pay');
    }

    /**
     * @return string
     */
    public static function getGatewayCode(): string
    {
        return 'DBRTP';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'direct';
    }
}
