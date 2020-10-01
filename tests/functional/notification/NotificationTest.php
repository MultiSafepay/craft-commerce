<?php namespace notification;

use Codeception\Stub;
use Codeception\Test\Unit;
use craft\commerce\elements\Order;
use craft\commerce\services\Orders;
use MultiSafepay\Api\Transactions\TransactionResponse;
use multisafepay\multisafepay\controllers\NotificationController;
use multisafepay\multisafepay\MultiSafepay;
use craft\commerce\Plugin as Commerce;

class NotificationTest extends Unit
{
    const ORDER_ID = 'abc12345';
    const TRANSACTION_ID = 'trans_abc12345';
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    protected function _before()
    {
        MultiSafepay::getInstance()->getSettings()->apiKey = '1111111111111111111111';
        MultiSafepay::getInstance()->getSettings()->testMode = '1';
        parent::_before();
    }

    public function testNoTransactionId()
    {
        $notificationController = new NotificationController('msp-notification', MultiSafepay::getInstance());

        $value = $notificationController->actionOrderStatus();
        $this->assertSame($notificationController::NOT_OK_STATUS, $value);
    }

    public function testUpdateOrderStatus()
    {
        MultiSafepay::getInstance()->getSettings()->orderStatusCompleted = 1;
        $this->tester->mockMethods(
            \Craft::$app,
            'request',
            ['getRequiredQueryParam' => '00001']
        );

        $this->tester->mockMethods(
            MultiSafepay::getInstance(),
            'transactionService',
            ['getTransaction' => new TransactionResponse(['order_id' => '00001', 'status' => 'completed'])]
        );

        /** @var Order $order */
        $order = Stub::construct(
            Order::class,
            [['couponCode' => 'discount_1', 'customerId' => '1000']],
            ['getEmail' => 'testing@craftcommerce.com']
        );

        $this->tester->mockMethods(
            Commerce::getInstance(),
            'orders',
            ['getOrderByNumber' => $order]
        );

        $notificationController = new NotificationController('msp-notification', MultiSafepay::getInstance());
        $value = $notificationController->actionOrderStatus();
        $this->assertSame($notificationController::NOT_OK_STATUS, $value);
    }
}
