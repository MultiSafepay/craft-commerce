<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways;

use Craft;
use craft\commerce\models\payments\BasePaymentForm;
use craft\web\View;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Ideal;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use multisafepay\multisafepay\gateways\base\BaseGateway;
use multisafepay\multisafepay\models\forms\IdealPaymentForm;
use multisafepay\multisafepay\MultiSafepay;
use multisafepay\multisafepay\services\IssuerService;

/**
 * Class IdealGateway
 * @package multisafepay\multisafepay\gateways
 */
class IdealGateway extends BaseGateway
{

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('multisafepay', 'iDEAL');
    }

    /**
     * @return string
     */
    public static function getGatewayCode(): string
    {
        return 'IDEAL';
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'direct';
    }

    /**
     * Returns payment Form HTML
     *
     * @param array $params
     * @return string|null
     */
    public function getPaymentFormHtml(array $params)
    {
        /** @var IssuerService $issuerService */
        $issuerService = MultiSafepay::getInstance()->issuerService;

        $issuers = $issuerService->getIssuersByGatewayCode(self::getGatewayCode());

        $oldMode = Craft::$app->view->getTemplateMode();
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        $html = Craft::$app->view->renderTemplate('multisafepay/issuers/ideal', [
            'issuers' => $issuers,
        ]);
        Craft::$app->view->setTemplateMode($oldMode);

        return $html;
    }

    /**
     * @param BasePaymentForm $form
     * @return GatewayInfoInterface
     */
    public function getGatewayInfo(BasePaymentForm $form): GatewayInfoInterface
    {
        $gatewayInfo = new Ideal();
        if (isset($form->issuerId)) {
            $gatewayInfo->addIssuerId($form->issuerId);
        }
        
        return $gatewayInfo;
    }

    /**
     * Returns payment form model to use in payment forms.
     *
     * @return BasePaymentForm
     */
    public function getPaymentFormModel(): BasePaymentForm
    {
        return new IdealPaymentForm();
    }
}
