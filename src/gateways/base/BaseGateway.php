<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\base;

use Craft;
use craft\commerce\base\Gateway as CommerceBaseGateway;
use craft\commerce\base\RequestResponseInterface;
use craft\commerce\models\payments\BasePaymentForm;
use craft\commerce\models\payments\OffsitePaymentForm;
use craft\commerce\models\PaymentSource;
use craft\commerce\models\Transaction;
use craft\web\Response as WebResponse;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use multisafepay\multisafepay\models\RefundResponse;
use multisafepay\multisafepay\models\RequestResponse;
use multisafepay\multisafepay\MultiSafepay;
use multisafepay\multisafepay\services\MoneyService;
use multisafepay\multisafepay\services\OrderService;
use multisafepay\multisafepay\services\TransactionService;
use yii\base\NotSupportedException;

/**
 * Class BaseGateway
 * @package multisafepay\multisafepay\gateways
 */
abstract class BaseGateway extends CommerceBaseGateway implements GatewayInterface
{
    const SUPPORTS_AUTHORIZE = false;
    const SUPPORTS_CAPTURE = false;
    const SUPPORTS_COMPLETE_AUTHORIZE = false;
    const SUPPORTS_COMPLETE_PURCHASE = true;
    const SUPPORTS_PAYMENT_SOURCES = false;
    const SUPPORTS_PURCHASE = true;
    const SUPPORTS_REFUND = true;
    const SUPPORTS_PARTIAL_REFUND = true;
    const SUPPORTS_WEBHOOKS = false;

    /**
     * @param BasePaymentForm $form
     * @return GatewayInfoInterface
     */
    public function getGatewayInfo(BasePaymentForm $form): GatewayInfoInterface
    {
        return new BaseGatewayInfo();
    }

    /**
     * Returns payment Form HTML
     *
     * @param array $params
     * @return string|null
     */
    public function getPaymentFormHtml(array $params)
    {
        return '';
    }

    /**
     * Makes an authorize request.
     *
     * @param Transaction     $transaction The authorize transaction
     * @param BasePaymentForm $form        A form filled with payment info
     * @return RequestResponseInterface
     * @throws NotSupportedException
     */
    public function authorize(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        throw new NotSupportedException('This functionality is not (yet) supported');
    }

    /**
     * Makes a capture request.
     *
     * @param Transaction $transaction The capture transaction
     * @param string      $reference   Reference for the transaction being captured.
     * @return RequestResponseInterface
     * @throws NotSupportedException
     */
    public function capture(Transaction $transaction, string $reference): RequestResponseInterface
    {
        throw new NotSupportedException('This functionality is not (yet) supported');
    }

    /**
     * Complete the authorization for offsite payments.
     *
     * @param Transaction $transaction The transaction
     * @return RequestResponseInterface
     * @throws NotSupportedException
     */
    public function completeAuthorize(Transaction $transaction): RequestResponseInterface
    {
        throw new NotSupportedException('This functionality is not (yet) supported');
    }

    /**
     * Complete the purchase for offsite payments.
     *
     * @param Transaction $transaction The transaction
     * @return RequestResponseInterface
     * @throws NotSupportedException
     */
    public function completePurchase(Transaction $transaction): RequestResponseInterface
    {
        /** @var TransactionService $transactionService */
        $transactionService = MultiSafepay::getInstance()->transactionService;

        $mspTransaction = $transactionService->getTransaction($transaction->getOrder()->number);

        return new RequestResponse($mspTransaction, $transaction);
    }

    /**
     * Creates a payment source from source data and user id.
     *
     * @param BasePaymentForm $sourceData
     * @param integer         $userId
     * @return PaymentSource
     * @throws NotSupportedException
     */
    public function createPaymentSource(BasePaymentForm $sourceData, int $userId): PaymentSource
    {
        throw new NotSupportedException('This functionality is not (yet) supported');
    }

    /**
     * Deletes a payment source on the gateway by its token.
     *
     * @param string $token
     * @return boolean
     * @throws NotSupportedException
     */
    public function deletePaymentSource($token): bool
    {
        throw new NotSupportedException('This functionality is not (yet) supported');
    }

    /**
     * Returns payment form model to use in payment forms.
     *
     * @return BasePaymentForm
     */
    public function getPaymentFormModel(): BasePaymentForm
    {
        return new OffsitePaymentForm();
    }

    /**
     * Makes a purchase request.
     *
     * @param Transaction     $transaction The purchase transaction
     * @param BasePaymentForm $form        A form filled with payment info
     * @return RequestResponseInterface
     */
    public function purchase(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    {
        /** @var OrderService $orderService */
        $orderService = MultiSafepay::getInstance()->orderService;

        /** @var TransactionService $transactionService */
        $transactionService = MultiSafepay::getInstance()->transactionService;

        $order = $orderService->createOrder($transaction, $this->getGatewayCode(), $this->getType(), $this->getGatewayInfo($form));
        
        $mspTransaction = $transactionService->createTransaction($order);

        return new RequestResponse($mspTransaction, $transaction);
    }

    /**
     * Makes a refund request.
     *
     * @param Transaction $transaction The refund transaction
     * @return RequestResponseInterface
     * @throws NotSupportedException
     */
    public function refund(Transaction $transaction): RequestResponseInterface
    {
        /** @var MoneyService $moneyService */
        $moneyService = MultiSafepay::getInstance()->moneyService;

        /** @var TransactionService $transactionService */
        $transactionService = MultiSafepay::getInstance()->transactionService;

        $mspTransaction = $transactionService->getTransaction($transaction->getOrder()->number);

        $refundRequest = $transactionService->createRefundRequest($mspTransaction);

        $refundRequest
            ->addDescriptionText($transaction->note)
            ->addMoney($moneyService->createMoney($transaction->paymentAmount, $transaction->paymentCurrency));

        $response = $transactionService->refund($mspTransaction, $refundRequest);

        return new RefundResponse($response, $transaction);
    }

    /**
     * Processes a webhook and return a response
     *
     * @return WebResponse
     * @throws NotSupportedException
     */
    public function processWebHook(): WebResponse
    {
        throw new NotSupportedException('This functionality is not (yet) supported');
    }

    /**
     * @return boolean
     */
    public function supportsAuthorize(): bool
    {
        return static::SUPPORTS_AUTHORIZE;
    }

    /**
     * @return boolean
     */
    public function supportsCapture(): bool
    {
        return static::SUPPORTS_CAPTURE;
    }

    /**
     * @return boolean
     */
    public function supportsCompleteAuthorize(): bool
    {
        return static::SUPPORTS_COMPLETE_AUTHORIZE;
    }

    /**
     * @return boolean
     */
    public function supportsCompletePurchase(): bool
    {
        return static::SUPPORTS_COMPLETE_PURCHASE;
    }

    /**
     * @return boolean
     */
    public function supportsPaymentSources(): bool
    {
        return static::SUPPORTS_PAYMENT_SOURCES;
    }

    /**
     * @return boolean
     */
    public function supportsPurchase(): bool
    {
        return static::SUPPORTS_PURCHASE;
    }

    /**
     * @return boolean
     */
    public function supportsRefund(): bool
    {
        return static::SUPPORTS_REFUND;
    }

    /**
     * @return boolean
     */
    public function supportsPartialRefund(): bool
    {
        return static::SUPPORTS_PARTIAL_REFUND;
    }

    /**
     * @return boolean
     */
    public function supportsWebhooks(): bool
    {
        return static::SUPPORTS_WEBHOOKS;
    }
}

