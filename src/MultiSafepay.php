<?php declare(strict_types=1);
/**
 * MultiSafepay plugin for Craft CMS 3.x
 *
 * Adding MultiSafepay payment functionality to Craft commerce
 *
 * @link      https://github.com/MultiSafepay/
 * @copyright Copyright (c) MultiSafepay
 */

namespace multisafepay\multisafepay;

use Craft;
use craft\base\Plugin;
use craft\commerce\events\OrderStatusEvent;
use craft\commerce\services\Gateways;
use craft\commerce\services\OrderHistories;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\web\UrlManager;
use multisafepay\multisafepay\gateways\base\BaseGateway;
use multisafepay\multisafepay\models\Settings;
use multisafepay\multisafepay\services\CustomerService;
use multisafepay\multisafepay\services\IssuerService;
use multisafepay\multisafepay\services\MoneyService;
use multisafepay\multisafepay\services\OrderService;
use multisafepay\multisafepay\services\SdkService;
use multisafepay\multisafepay\services\ShoppingCartService;
use multisafepay\multisafepay\services\TaxService;
use multisafepay\multisafepay\services\TransactionService;
use yii\base\Event;
use yii\web\Response;

/**
 * @author    MultiSafepay
 * @package   MultiSafepay
 * @since     1.0.0
 *
 */
class MultiSafepay extends Plugin
{

    public const SHOP_TYPE_NAME = 'CraftCommerce';

    /**
     * @var MultiSafepay
     */
    public static $plugin;

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = true;

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'sdkService' => SdkService::class,
            'orderService' => OrderService::class,
            'moneyService' => MoneyService::class,
            'shoppingCartService' => ShoppingCartService::class,
            'transactionService' => TransactionService::class,
            'customerService' => CustomerService::class,
            'taxService' => TaxService::class,
            'issuerService' => IssuerService::class,
        ]);

        Event::on(
            Gateways::class,
            Gateways::EVENT_REGISTER_GATEWAY_TYPES,
            function (RegisterComponentTypesEvent $event): void {
                foreach (\multisafepay\multisafepay\models\Gateways::GATEWAYS as $gateway) {
                    $event->types[] = $gateway;
                }
                foreach (\multisafepay\multisafepay\models\Giftcards::GIFTCARDS as $giftcard) {
                    $event->types[] = $giftcard;
                }
            }
        );

        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function (RegisterUrlRulesEvent $e): void {
            $e->rules['multisafepay'] = 'multisafepay/settings/general-settings';
            $e->rules['multisafepay/settings/order-status'] = 'multisafepay/settings/order-status-settings';
        });

        Event::on(OrderHistories::class, OrderHistories::EVENT_ORDER_STATUS_CHANGE, function (OrderStatusEvent $event): void {
            if (!MultiSafepay::getInstance()->orderService->shouldSendShippedStatusToMultiSafepay($event->orderHistory)) {
                return;
            }

            if (!$event->order->getGateway() instanceof BaseGateway) {
                return;
            }

            $orderUpdate = MultiSafepay::getInstance()->orderService->createOrderUpdate($event->order);
            MultiSafepay::getInstance()->transactionService->updateTransaction($event->order->number, $orderUpdate);
        });
    }

    /**
     * @return \craft\base\Model|Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * @return Response
     */
    public function getSettingsResponse(): Response
    {
        return Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('multisafepay'));
    }

    /**
     * @return array
     */
    public function getCpNavItem(): array
    {
        $item = parent::getCpNavItem();
        $item['subnav'] = [
            'settings' => ['label' => 'Settings', 'url' => 'multisafepay'],
            'support' => ['label' => 'Support', 'url' => 'multisafepay/support'],
        ];
        return $item;
    }
}
