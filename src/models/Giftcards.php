<?php declare(strict_types=1);

namespace multisafepay\multisafepay\models;

use multisafepay\multisafepay\gateways\giftcards\BabyCadeaubonGiftcard;
use multisafepay\multisafepay\gateways\giftcards\BeautyWellnessGiftcard;
use multisafepay\multisafepay\gateways\giftcards\BoekenbonGiftcard;
use multisafepay\multisafepay\gateways\giftcards\FashionchequeGiftcard;
use multisafepay\multisafepay\gateways\giftcards\FashiongiftcardGiftcard;
use multisafepay\multisafepay\gateways\giftcards\FietsenbonGiftcard;
use multisafepay\multisafepay\gateways\giftcards\GezondheidsbonGiftcard;
use multisafepay\multisafepay\gateways\giftcards\GivaCardGiftcard;
use multisafepay\multisafepay\gateways\giftcards\GoodCardGiftcard;
use multisafepay\multisafepay\gateways\giftcards\NationaleTuinbonGiftcard;
use multisafepay\multisafepay\gateways\giftcards\ParfumCadeaukaartGiftcard;
use multisafepay\multisafepay\gateways\giftcards\PodiumGiftcard;
use multisafepay\multisafepay\gateways\giftcards\SportFitGiftcard;
use multisafepay\multisafepay\gateways\giftcards\VVVCadeaukaartGiftcard;
use multisafepay\multisafepay\gateways\giftcards\WebshopGiftcardGiftcard;
use multisafepay\multisafepay\gateways\giftcards\WellnessgiftcardGiftcard;
use multisafepay\multisafepay\gateways\giftcards\WijncadeauGiftcard;
use multisafepay\multisafepay\gateways\giftcards\WinkelchequeGiftcard;
use multisafepay\multisafepay\gateways\giftcards\YourGiftGiftcard;

class Giftcards
{
    const GIFTCARDS = [
        BabyCadeaubonGiftcard::class,
        BeautyWellnessGiftcard::class,
        BoekenbonGiftcard::class,
        FashionchequeGiftcard::class,
        FashiongiftcardGiftcard::class,
        FietsenbonGiftcard::class,
        GezondheidsbonGiftcard::class,
        GivaCardGiftcard::class,
        GoodCardGiftcard::class,
        NationaleTuinbonGiftcard::class,
        PodiumGiftcard::class,
        ParfumCadeaukaartGiftcard::class,
        SportFitGiftcard::class,
        VVVCadeaukaartGiftcard::class,
        WebshopGiftcardGiftcard::class,
        WellnessgiftcardGiftcard::class,
        WijncadeauGiftcard::class,
        WinkelchequeGiftcard::class,
        YourGiftGiftcard::class,
    ];
}
