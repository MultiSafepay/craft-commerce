<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use craft\base\Component;
use MultiSafepay\ValueObject\Money;

class MoneyService extends Component
{
    public const STANDARD_CURRENCY_CODE = 'EUR';

    /**
     * @param float  $amount
     * @param string $currencyCode
     * @return Money
     */
    public function createMoney(float $amount, string $currencyCode = self::STANDARD_CURRENCY_CODE): Money
    {
        return new Money($this->priceToCents($amount), $currencyCode);
    }

    /**
     * @param float $price
     * @return float|integer
     */
    private function priceToCents(float $price)
    {
        return $price * 100;
    }
}
