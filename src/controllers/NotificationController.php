<?php declare(strict_types=1);

namespace multisafepay\multisafepay\controllers;

use Craft;
use craft\commerce\models\Transaction;
use craft\commerce\Plugin;
use craft\web\Controller;
use multisafepay\multisafepay\models\Gateways;
use multisafepay\multisafepay\models\Settings;
use multisafepay\multisafepay\MultiSafepay;
use multisafepay\multisafepay\services\OrderService;
use multisafepay\multisafepay\services\TransactionService;
use Psr\Http\Client\ClientExceptionInterface;
use yii\web\BadRequestHttpException;

class NotificationController extends Controller
{
    public const OK_STATUS = 'ok';
    public const NOT_OK_STATUS = 'ng';

    protected array|bool|int $allowAnonymous = ['order-status'];

    /**
     * @var TransactionService
     */
    protected $transactionService;

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();
        $this->transactionService = MultiSafepay::getInstance()->transactionService;
        $this->orderService = MultiSafepay::getInstance()->orderService;
    }

    /**
     * @return string
     * @throws ClientExceptionInterface
     * @throws \Throwable
     */
    public function actionOrderStatus(): string
    {
        try {
            $transactionId = Craft::$app->getRequest()->getRequiredQueryParam('transactionid');
        } catch (BadRequestHttpException $e) {
            return self::NOT_OK_STATUS;
        }

        $mspTransaction = $this->transactionService->getTransaction($transactionId);

        $transactionHash = $mspTransaction->getVar1();

        if (!isset($transactionHash)) {
            return self::NOT_OK_STATUS;
        }

        $commercePlugin = Plugin::getInstance();
        $transaction = $commercePlugin->transactions->getTransactionByHash($transactionHash);

        if (!isset($transaction)) {
            return self::NOT_OK_STATUS;
        }

        $status = $mspTransaction->getStatus();
        $gateway = $transaction->getGateway();

        // If the transaction has been paid, set to completed
        if ($status === Settings::ORDER_STATUS_COMPLETED || (isset($gateway) && in_array(
            get_class($gateway),
            Gateways::GATEWAYS_THAT_REQUIRE_PROCESSING,
            true
        ))) {
            $error = '';
            $commercePlugin->getPayments()->completePayment($transaction, $error);
        }

        // Get the order again from the db, because completePayment makes changes to the order
        $order = $this->orderService->getOrder($mspTransaction->getOrderId());

        $success = $this->orderService->updateOrderStatus($order, $status);

        if (!$success) {
            return self::NOT_OK_STATUS;
        }

        return self::OK_STATUS;
    }
}
