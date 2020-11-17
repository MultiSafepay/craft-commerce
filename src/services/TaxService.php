<?php declare(strict_types=1);


namespace multisafepay\multisafepay\services;

use craft\base\Component;
use craft\commerce\elements\Order;
use craft\commerce\models\LineItem;
use craft\commerce\records\TaxRate as TaxRateRecord;

class TaxService extends Component
{
    /**
     * @param Order $order
     * @return integer
     */
    public function getItemTaxRate(Order $order): int
    {

        $taxObject = $order->getAdjustmentsByType('tax');
        $taxRate = 0;
        if (!empty($taxObject)) {
            $taxOptions = $taxObject[0]->getSourceSnapshot();
            $taxableSubject = $taxOptions['taxable'];

            if ($taxableSubject === TaxRateRecord::TAXABLE_PRICE ||
                $taxableSubject === TaxRateRecord::TAXABLE_PRICE_SHIPPING ||
                $taxableSubject === TaxRateRecord::TAXABLE_ORDER_TOTAL_PRICE
            ) {
                $taxRate = (int)($taxOptions['rate'] * 100);
            }
        }

        return $taxRate;
    }

    /**
     * @param Order $order
     * @return integer
     */
    public function getShippingTaxRate(Order $order): int
    {
        // For now we only support simple shipping tax scenarios
        $taxObject = $order->getAdjustmentsByType('tax');
        $taxRate = 0;
        if (!empty($taxObject)) {
            $taxOptions = $taxObject[0]->getSourceSnapshot();
            $taxableSubject = $taxOptions['taxable'];
            if ($taxableSubject === TaxRateRecord::TAXABLE_ORDER_TOTAL_PRICE ||
                $taxableSubject === TaxRateRecord::TAXABLE_ORDER_TOTAL_SHIPPING
            ) {
                $taxRate = (int)($taxOptions['rate'] * 100);
            }
        }

        return $taxRate;
    }

    /**
     * Returns correct item price (excl tax)
     * @param LineItem $item
     * @return float
     */
    public function getItemPrice(LineItem $item): float
    {
        $itemPrice = $item->getOnSale() ? $item->getSaleAmount() : $item->getPrice();
        if ($this->isTaxIncluded($item->getOrder())) {
            $itemTaxRate = $this->getItemTaxRate($item->getOrder()) / 100;
            $itemPrice = round($itemPrice / (1 + $itemTaxRate), 10);
        }
        return $itemPrice;
    }

    /**
     * Returns correct shipping price (excl tax)
     * @param Order $order
     * @return float
     */
    public function getShippingPrice(Order $order): float
    {
        $shippingPrice = $order->getTotalShippingCost();
        if ($this->isTaxIncluded($order)) {
            $shippingTaxRate = $this->getShippingTaxRate($order) / 100;
            $shippingPrice = round($shippingPrice / (1 + $shippingTaxRate), 10);
        }
        return $shippingPrice;
    }

    /**
     * @param Order $order
     * @return boolean
     */
    public function isTaxIncluded(Order $order): bool
    {
        $adjustments = $order->getAdjustmentsByType('tax');
        foreach ($adjustments as $adjustment) {
            return $adjustment->included;
        }
        return false;
    }
}
