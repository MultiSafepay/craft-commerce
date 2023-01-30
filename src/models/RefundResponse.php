<?php declare(strict_types=1);


namespace multisafepay\multisafepay\models;

use craft\commerce\base\RequestResponseInterface;
use craft\commerce\models\Transaction;
use MultiSafepay\Api\Base\Response;
use yii\base\NotSupportedException;

/**
 * Class RequestResponse
 * @package multisafepay\multisafepay\models
 */
class RefundResponse implements RequestResponseInterface
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * RefundResponse constructor.
     * @param Response    $response
     * @param Transaction $transaction
     */
    public function __construct(Response $response, Transaction $transaction)
    {
        $this->response = $response;
        $this->transaction = $transaction;
    }

    /**
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return isset($this->response->getResponseData()['refund_id']);
    }

    /**
     * @return boolean
     * @throws NotSupportedException
     */
    public function isProcessing(): bool
    {
        throw new NotSupportedException('This functionality is not supported');
    }

    /**
     * @return boolean
     * @throws NotSupportedException
     */
    public function isRedirect(): bool
    {
        throw new NotSupportedException('This functionality is not supported');
    }

    /**
     * @return string
     * @throws NotSupportedException
     */
    public function getRedirectMethod(): string
    {
        throw new NotSupportedException('This functionality is not supported');
    }

    /**
     * @return array
     * @throws NotSupportedException
     */
    public function getRedirectData(): array
    {
        throw new NotSupportedException('This functionality is not supported');
    }

    /**
     * @return string
     * @throws NotSupportedException
     */
    public function getRedirectUrl(): string
    {
        throw new NotSupportedException('This functionality is not supported');
    }

    /**
     * @return string
     */
    public function getTransactionReference(): string
    {
        return $this->transaction->getOrder()->number;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return '';
    }

    /**
     * @return array|mixed
     */
    public function getData(): mixed
    {
        return $this->response->getResponseData();
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return '';
    }

    /**
     * @return mixed|void
     * @throws NotSupportedException
     */
    public function redirect() : void
    {
        throw new NotSupportedException('This functionality is not supported');
    }
}
