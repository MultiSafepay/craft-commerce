<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use craft\base\Component;
use craft\commerce\elements\Order;
use craft\commerce\errors\CurrencyException;
use craft\commerce\models\LineItem;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use multisafepay\multisafepay\MultiSafepay;
use MultiSafepay\ValueObject\CartItem;
use yii\base\InvalidConfigException;

class ShoppingCartService extends Component
{
    /**
     * @var MoneyService
     */
    protected $moneyService;

    /**
     * @var TaxService
     */
    protected $taxService;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->moneyService = MultiSafepay::getInstance()->moneyService;
        $this->taxService = MultiSafepay::getInstance()->taxService;
    }

    /**
     * @param Order $order
     * @return ShoppingCart
     * @throws CurrencyException
     * @throws InvalidConfigException
     */
    public function createShoppingCart(Order $order): ShoppingCart
    {
        $items = [];
        foreach ($order->getLineItems() as $lineItem) {
            $items[] = $this->createCartItem($lineItem, $order->getPaymentCurrency());
        }

        $shippingItem = $this->createShippingCostItem($order);

        if (isset($shippingItem)) {
            $items[] = $shippingItem;
        }
        return new ShoppingCart($items);
    }

    /**
     * @param LineItem $item
     * @param string   $currency
     * @return CartItem
     */
    private function createCartItem(LineItem $item, string $currency): CartItem
    {
        $cartItem = new CartItem();
        return $cartItem->addName($item->getDescription())
            ->addQuantity($item->qty)
            ->addMerchantItemId($item->getSku())
            ->addUnitPrice($this->moneyService->createMoney($this->taxService->getItemPrice($item), $currency))
            ->addTaxRate($this->taxService->getItemTaxRate($item->getOrder()));
    }

    /**
     * @param Order $order
     * @return CartItem
     * @throws CurrencyException
     * @throws InvalidConfigException
     */
    private function createShippingCostItem(Order $order): ?CartItem
    {
        $cartItem = new CartItem();
        $shippingMethod = $order->getShippingMethod();
        if (! isset($shippingMethod)) {
            return null;
        }
        return $cartItem->addName($order->getShippingMethod()->getName())
            ->addQuantity(1)
            ->addUnitPrice($this->moneyService->createMoney($this->taxService->getShippingPrice($order), $order->getPaymentCurrency()))
            ->addTaxRate($this->taxService->getShippingTaxRate($order))
            ->addMerchantItemId('msp-shipping');
    }
}
