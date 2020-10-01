<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use craft\base\Component;
use MultiSafepay\Api\Base\Response;
use MultiSafepay\Api\TransactionManager;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Api\Transactions\UpdateRequest;
use multisafepay\multisafepay\MultiSafepay;
use Psr\Http\Client\ClientExceptionInterface;

class TransactionService extends Component
{
    /**
     * @var TransactionManager
     */
    protected $transactionManager;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->transactionManager = MultiSafepay::getInstance()->sdkService->getSdk()->getTransactionManager();
    }

    /**
     * @param OrderRequest $order
     * @return TransactionResponse
     * @throws ClientExceptionInterface
     */
    public function createTransaction(OrderRequest $order): TransactionResponse
    {
        return $this->transactionManager->create($order);
    }

    /**
     * @param string $orderId
     * @return TransactionResponse
     * @throws ClientExceptionInterface
     */
    public function getTransaction(string $orderId): TransactionResponse
    {
        return $this->transactionManager->get($orderId);
    }

    /**
     * @param TransactionResponse $transaction
     * @param RefundRequest       $requestRefund
     * @return Response
     * @throws ClientExceptionInterface
     */
    public function refund(TransactionResponse $transaction, RefundRequest $requestRefund): Response
    {
        return $this->transactionManager->refund($transaction, $requestRefund);
    }

    /**
     * @param string        $orderId
     * @param UpdateRequest $updateRequest
     * @return Response
     * @throws ClientExceptionInterface
     */
    public function updateTransaction(string $orderId, UpdateRequest $updateRequest): Response
    {
        return $this->transactionManager->update($orderId, $updateRequest);
    }

    /**
     * @param TransactionResponse $transaction
     * @return RefundRequest
     */
    public function createRefundRequest(TransactionResponse $transaction): RefundRequest
    {
        return $this->transactionManager->createRefundRequest($transaction);
    }
}
