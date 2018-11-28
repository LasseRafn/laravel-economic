<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\PaymentTerm;

class PaymentTermBuilder extends Builder
{
    protected $entity = 'payment-terms';
    protected $model = PaymentTerm::class;
}
