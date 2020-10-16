<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use craft\base\Component;
use MultiSafepay\Api\IssuerManager;
use multisafepay\multisafepay\MultiSafepay;

class IssuerService extends Component
{
    /**
     * @var IssuerManager
     */
    protected $issuerManager;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->issuerManager = MultiSafepay::getInstance()->sdkService->getSdk()->getIssuerManager();
    }

    /**
     * @param string $gatewayCode
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getIssuersByGatewayCode(string $gatewayCode): array
    {
        return $this->issuerManager->getIssuersByGatewayCode($gatewayCode);
    }
}
