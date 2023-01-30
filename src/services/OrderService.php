<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use craft\base\Component;
use craft\commerce\elements\Order;
use craft\commerce\errors\CurrencyException;
use craft\commerce\models\OrderHistory;
use craft\commerce\models\Transaction;
use craft\commerce\Plugin as Commerce;
use craft\errors\ElementNotFoundException;
use craft\helpers\UrlHelper;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\UpdateRequest;
use multisafepay\multisafepay\MultiSafepay;
use yii\base\Exception;
use yii\base\InvalidConfigException;

class OrderService extends Component
{
    public const STATUS_SHIPPED = 'shipped';
    public const NOTIFICATION_URL = 'multisafepay/notification/order-status';
    /**
     * @var MoneyService
     */
    protected $moneyService;

    /**
     * @var ShoppingCartService
     */
    protected $shoppingCartService;

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->moneyService = MultiSafepay::getInstance()->moneyService;
        $this->shoppingCartService = MultiSafepay::getInstance()->shoppingCartService;
        $this->customerService = MultiSafepay::getInstance()->customerService;
    }

    /**
     * @param Transaction          $transaction
     * @param string               $gatewayCode
     * @param string               $type
     * @param GatewayInfoInterface $gatewayInfo
     * @return OrderRequest
     * @throws CurrencyException
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function createOrder(
        Transaction $transaction,
        string $gatewayCode = '',
        string $type = 'redirect',
        GatewayInfoInterface $gatewayInfo = null
    )
    {
        $order = new OrderRequest();
        $order->addOrderId($transaction->getOrder()->number)
            ->addMoney($this->moneyService->createMoney($transaction->amount, $transaction->currency))
            ->addGatewayCode($gatewayCode)
            ->addType($type)
            ->addPluginDetails($this->createPluginDetails())
            ->addGatewayInfo($gatewayInfo)
            ->addDescription($this->createDescription($transaction->orderId))
            ->addPaymentOptions($this->createPaymentOptions($transaction))
            ->addShoppingCart($this->shoppingCartService->createShoppingCart($transaction->getOrder()))
            ->addCustomer($this->customerService->createCustomerDetails($transaction->getOrder()))
            ->addDelivery($this->customerService->createDeliveryDetails($transaction->getOrder()))
            // We add the transaction hash so the notification url can find the transaction
            ->addData(['var1' => $transaction->hash]);
        return $order;
    }

    /**
     * @param Order  $order
     * @param string $status
     * @return boolean
     */
    public function updateOrderStatus(Order $order, string $status)
    {
        $newStatus = MultiSafepay::getInstance()->getSettings()->getStatusIdByMspCode($status);

        if (!isset($newStatus)) {
            return false;
        }

        $order->orderStatusId = (int) $newStatus;
        try {
            \Craft::$app->getElements()->saveElement($order);
        } catch (ElementNotFoundException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }

    /**
     * @param OrderHistory $orderHistory
     * @return boolean
     */
    public function shouldSendShippedStatusToMultiSafepay(OrderHistory $orderHistory)
    {
        $shippedStatusId = (int)MultiSafepay::getInstance()->getSettings()->statusShipped;
        $defaultStatusId = (int)Commerce::getInstance()->orderStatuses->getDefaultOrderStatusId();

        if ($shippedStatusId !== $defaultStatusId && (int)$orderHistory->newStatus->id === $shippedStatusId) {
            return true;
        }

        return false;
    }

    /**
     * @param Order $order
     * @return UpdateRequest
     */
    public function createOrderUpdate(Order $order)
    {
        $orderUpdate = new UpdateRequest();
        $orderUpdate->addId($order->number)->addStatus(self::STATUS_SHIPPED);

        return $orderUpdate;
    }

    /**
     * @param string $orderId
     * @return Order
     */
    public function getOrder(string $orderId)
    {
        return Commerce::getInstance()->getOrders()->getOrderByNumber($orderId);
    }

    /**
     * @return PluginDetails
     */
    private function createPluginDetails(): PluginDetails
    {
        $pluginDetails = new PluginDetails();
        return $pluginDetails
            ->addApplicationName(MultiSafepay::SHOP_TYPE_NAME)
            ->addApplicationVersion(Commerce::getInstance()->getVersion())
            ->addPluginVersion(MultiSafepay::getInstance()->getVersion());
    }

    /**
     * @param integer $orderId
     * @return Description
     */
    private function createDescription(int $orderId): Description
    {
        $description = new Description();
        return $description->addDescription('Payment for order #' . $orderId);
    }

    /**
     * @param Transaction $transaction
     * @return PaymentOptions
     * @throws Exception
     */
    private function createPaymentOptions(Transaction $transaction): PaymentOptions
    {
        $paymentOptions = new PaymentOptions();

        //If someone forgets to add https:// to DEFAULT_SITE_URL in the env file, this has to be added to fix the callback urls
        $cancelUrl = UrlHelper::siteUrl($transaction->getOrder()->cancelUrl);
        if (parse_url($cancelUrl, PHP_URL_SCHEME) === null) {
            $cancelUrl = "https://{$cancelUrl}";
        }

        $returnUrl = UrlHelper::actionUrl(
            'commerce/payments/complete-payment',
            ['commerceTransactionId' => $transaction->id, 'commerceTransactionHash' => $transaction->hash]
        );
        if (parse_url($returnUrl, PHP_URL_SCHEME) === null) {
            $returnUrl = "https://{$returnUrl}";
        }

        return $paymentOptions
            ->addCancelUrl($cancelUrl)
            ->addRedirectUrl($returnUrl)
            ->addNotificationUrl(UrlHelper::actionUrl(self::NOTIFICATION_URL))
            ->addNotificationMethod('GET');
    }
}
