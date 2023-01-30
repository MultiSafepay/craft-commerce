<?php declare(strict_types=1);



namespace multisafepay\multisafepay\gateways;

use Craft;
use multisafepay\multisafepay\gateways\base\BaseGateway;

/**
 * Class GenericGateway
 * @package multisafepay\multisafepay\gateways
 */
class GenericGateway extends BaseGateway
{
    const SUPPORTS_REFUND = false;
    const SUPPORTS_PARTIAL_REFUND = false;

    /**
     * @var string
     */
    private $gatewayCode = '';

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'Generic gateway');
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return $this->gatewayCode;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'redirect';
    }

    /**
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('multisafepay/gateways/gatewaySettings', ['gateway' => $this]);
    }

    /**
     * @param string $gatewayCode
     * @return void
     */
    public function setGatewayCode(string $gatewayCode): void
    {
        $this->gatewayCode = $gatewayCode;
    }

}
