<?php declare(strict_types=1);

namespace multisafepay\multisafepay\controllers;

use Craft;
use craft\web\Controller;
use multisafepay\multisafepay\MultiSafepay;
use multisafepay\multisafepay\services\OrderService;
use multisafepay\multisafepay\services\TransactionService;
use yii\web\BadRequestHttpException;

class NotificationController extends Controller
{
    public const OK_STATUS = 'ok';
    public const NOT_OK_STATUS = 'ng';

    protected $allowAnonymous = true;

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
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Throwable
     * @throws \craft\errors\ElementNotFoundException
     * @throws \yii\base\Exception
     */
    public function actionOrderStatus(): string
    {
        try {
            $transactionId = Craft::$app->getRequest()->getRequiredQueryParam('transactionid');
        } catch (BadRequestHttpException $e) {
            return self::NOT_OK_STATUS;
        }

        $transaction = $this->transactionService->getTransaction($transactionId);
        $success = $this->orderService->updateOrderStatus($transaction);

        if (!$success) {
            return self::NOT_OK_STATUS;
        }

        return self::OK_STATUS;
    }
}
