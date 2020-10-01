<?php


namespace unit\money;

use \Codeception\Test\Unit;
use multisafepay\multisafepay\services\MoneyService;

class MoneyTest extends Unit
{
    public const AMOUNT = 10;
    public const AMOUNT_IN_CENTS_STRING = '1000';
    public const CURRENCY = 'USD';

    protected $moneyService;

    public function _before()
    {
        parent::_before();

        $this->moneyService = new MoneyService();
    }

    public function testAmountToCents()
    {
        $money = $this->moneyService->createMoney(self::AMOUNT);

        $this->assertSame(
            self::AMOUNT_IN_CENTS_STRING,
            $money->getAmount()
        );
    }

    public function testCorrectCurrency()
    {
        $money = $this->moneyService->createMoney(self::AMOUNT, self::CURRENCY);

        $this->assertSame(
            self::CURRENCY,
            $money->getCurrency()->getCode()
        );
    }

}