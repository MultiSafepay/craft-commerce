<?php declare(strict_types=1);

namespace multisafepay\multisafepay\models;

use craft\base\Model;

class Settings extends Model
{

    public const ORDER_STATUS_INITIALIZED = 'initialized';
    public const ORDER_STATUS_UNCLEARED = 'uncleared';
    public const ORDER_STATUS_RESERVED = 'reserved';
    public const ORDER_STATUS_VOID = 'void';
    public const ORDER_STATUS_DECLINED = 'declined';
    public const ORDER_STATUS_CHARGEBACK = 'chargeback';
    public const ORDER_STATUS_REFUNDED = 'refunded';
    public const ORDER_STATUS_EXPIRED = 'expired';
    public const ORDER_STATUS_PARTIAL_REFUNDED = 'partial_refunded';
    public const ORDER_STATUS_COMPLETED = 'completed';

    public $testMode = false;
    public $apiKey = '';
    public $statusShipped = "1";
    public $orderStatusInitialized = "1";
    public $orderStatusUncleared = "1";
    public $orderStatusReserved = "1";
    public $orderStatusVoid = "1";
    public $orderStatusDeclined = "1";
    public $orderStatusChargeback = "1";
    public $orderStatusRefunded = "1";
    public $orderStatusExpired = "1";
    public $orderStatusPartialRefunded = "1";
    public $orderStatusCompleted = "1";

    /**
     * @return array
     */
    public function rules()
    {
        return [[['apiKey'], 'required'], ];
    }

    /**
     * @param string $statusCode
     * @return string|null
     */
    public function getStatusIdByMspCode(string $statusCode)
    {
        switch ($statusCode) {
            case self::ORDER_STATUS_INITIALIZED:
                return $this->orderStatusInitialized;
            case self::ORDER_STATUS_UNCLEARED:
                return $this->orderStatusUncleared;
            case self::ORDER_STATUS_RESERVED:
                return $this->orderStatusReserved;
            case self::ORDER_STATUS_VOID:
                return $this->orderStatusVoid;
            case self::ORDER_STATUS_DECLINED:
                return $this->orderStatusDeclined;
            case self::ORDER_STATUS_CHARGEBACK:
                return $this->orderStatusChargeback;
            case self::ORDER_STATUS_REFUNDED:
                return $this->orderStatusRefunded;
            case self::ORDER_STATUS_EXPIRED:
                return $this->orderStatusExpired;
            case self::ORDER_STATUS_PARTIAL_REFUNDED:
                return $this->orderStatusPartialRefunded;
            case self::ORDER_STATUS_COMPLETED:
                return $this->orderStatusCompleted;
        }

        return null;
    }
}
