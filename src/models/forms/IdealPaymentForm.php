<?php declare(strict_types=1);

namespace multisafepay\multisafepay\models\forms;

use craft\commerce\models\payments\OffsitePaymentForm;

class IdealPaymentForm extends OffsitePaymentForm
{
    public $issuerId;
}
