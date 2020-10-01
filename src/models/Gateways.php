<?php declare(strict_types=1);

namespace multisafepay\multisafepay\models;

use multisafepay\multisafepay\gateways\AfterPayGateway;
use multisafepay\multisafepay\gateways\AlipayGateway;
use multisafepay\multisafepay\gateways\AmexGateway;
use multisafepay\multisafepay\gateways\BancontactGateway;
use multisafepay\multisafepay\gateways\BankTransferGateway;
use multisafepay\multisafepay\gateways\BelfiusGateway;
use multisafepay\multisafepay\gateways\CBCGateway;
use multisafepay\multisafepay\gateways\CreditCardGateway;
use multisafepay\multisafepay\gateways\DotpayGateway;
use multisafepay\multisafepay\gateways\EInvoicingGateway;
use multisafepay\multisafepay\gateways\EPSGateway;
use multisafepay\multisafepay\gateways\GiropayGateway;
use multisafepay\multisafepay\gateways\IdealGateway;
use multisafepay\multisafepay\gateways\IdealQRGateway;
use multisafepay\multisafepay\gateways\In3Gateway;
use multisafepay\multisafepay\gateways\INGHomePayGateway;
use multisafepay\multisafepay\gateways\KBCGateway;
use multisafepay\multisafepay\gateways\KlarnaGateway;
use multisafepay\multisafepay\gateways\MaestroGateway;
use multisafepay\multisafepay\gateways\MastercardGateway;
use multisafepay\multisafepay\gateways\PayAfterDeliveryGateway;
use multisafepay\multisafepay\gateways\PaypalGateway;
use multisafepay\multisafepay\gateways\RedirectGateway;
use multisafepay\multisafepay\gateways\RequestToPayGateway;
use multisafepay\multisafepay\gateways\SantanderGateway;
use multisafepay\multisafepay\gateways\SEPADirectDebitGateway;
use multisafepay\multisafepay\gateways\SOFORTGateway;
use multisafepay\multisafepay\gateways\TrustlyGateway;
use multisafepay\multisafepay\gateways\TrustPayGateway;
use multisafepay\multisafepay\gateways\VisaGateway;

class Gateways
{
    const GATEWAYS = [
        AfterPayGateway::class,
        AlipayGateway::class,
        AmexGateway::class,
        BancontactGateway::class,
        BankTransferGateway::class,
        BelfiusGateway::class,
        CBCGateway::class,
        CreditCardGateway::class,
        DotpayGateway::class,
        EInvoicingGateway::class,
        EPSGateway::class,
        GiropayGateway::class,
        IdealGateway::class,
        IdealQRGateway::class,
        In3Gateway::class,
        INGHomePayGateway::class,
        KBCGateway::class,
        KlarnaGateway::class,
        MaestroGateway::class,
        MastercardGateway::class,
        PayAfterDeliveryGateway::class,
        PaypalGateway::class,
        RedirectGateway::class,
        RequestToPayGateway::class,
        SantanderGateway::class,
        SEPADirectDebitGateway::class,
        SOFORTGateway::class,
        TrustlyGateway::class,
        TrustPayGateway::class,
        VisaGateway::class,
    ];
}
