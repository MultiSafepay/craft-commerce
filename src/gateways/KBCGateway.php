<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class KBCGateway
 * @package multisafepay\multisafepay\gateways
 */
class KBCGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'KBC');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'KBC';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'direct';
    }
}
