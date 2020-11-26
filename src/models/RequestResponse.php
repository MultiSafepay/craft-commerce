<?php declare(strict_types=1);


namespace multisafepay\multisafepay\models;

use craft\commerce\base\RequestResponseInterface;
use craft\commerce\models\Transaction;
use MultiSafepay\Api\Transactions\TransactionResponse;
use yii\base\NotSupportedException;

/**
 * Class RequestResponse
 * @package multisafepay\multisafepay\models
 */
class RequestResponse implements RequestResponseInterface
{
    public const MSP_REDIRECT_METHOD = 'GET';

    /**
     * @var TransactionResponse
     */
    protected $response;

    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * RequestResponse constructor.
     * @param TransactionResponse $response
     * @param Transaction         $transaction
     */
    public function __construct(TransactionResponse $response, Transaction $transaction)
    {
        $this->response = $response;
        $this->transaction = $transaction;
    }

    /**
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return $this->response->getStatus() === Settings::ORDER_STATUS_COMPLETED;
    }

    /**
     * @return boolean
     */
    public function isProcessing(): bool
    {
        $paymentUrl = $this->response->getPaymentUrl();

        return empty($paymentUrl) && $this->response->getStatus() === Settings::ORDER_STATUS_INITIALIZED;
    }

    /**
     * @return boolean
     */
    public function isRedirect(): bool
    {
        $paymentUrl = $this->response->getPaymentUrl();

        return !empty($paymentUrl);
    }

    /**
     * @return string
     */
    public function getRedirectMethod(): string
    {
        return self::MSP_REDIRECT_METHOD;
    }

    /**
     * @return array
     */
    public function getRedirectData(): array
    {
        return $this->response->getData();
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->response->getPaymentUrl();
    }

    /**
     * @return string
     */
    public function getTransactionReference(): string
    {
        return $this->response->getOrderId();
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->response->getStatus();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->response->getData();
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->response->getDescription();
    }

    /**
     * @return void
     * @throws NotSupportedException
     */
    public function redirect(): void
    {
        throw new NotSupportedException('This functionality is not (yet) supported');
    }
}
