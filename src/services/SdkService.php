<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use Craft;
use craft\base\Component;
use multisafepay\multisafepay\MultiSafepay;
use MultiSafepay\Sdk;

class SdkService extends Component
{
    /**
     * @var Sdk
     */
    protected $sdk;

    /**
     * @return void
     */
    public function init(): void
    {
        $apiKey = Craft::parseEnv(MultiSafepay::getInstance()->getSettings()->apiKey);
        $isProduction = !(Craft::parseEnv(MultiSafepay::getInstance()->getSettings()->testMode));
        $this->sdk = new Sdk($apiKey, $isProduction);
    }

    /**
     * @return Sdk
     */
    public function getSdk(): Sdk
    {
        return $this->sdk;
    }
}
