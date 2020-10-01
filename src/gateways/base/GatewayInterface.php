<?php declare(strict_types=1);


namespace multisafepay\multisafepay\gateways\base;


interface GatewayInterface
{
    /**
     * @return string
     */
    public static function displayName(): string;

    /**
     * @return string
     */
    public static function getGatewayCode(): string;

    /**
     * @return string
     */
    public static function getType(): string;
}

