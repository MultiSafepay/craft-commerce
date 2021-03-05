<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class AlipayGateway
 * @package multisafepay\multisafepay\gateways
 */
class AlipayGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Alipay');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return 'ALIPAY';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'direct';
    }
}
