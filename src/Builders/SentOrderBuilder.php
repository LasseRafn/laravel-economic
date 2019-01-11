<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\SentOrder;

class SentOrderBuilder extends Builder
{
    protected $entity = 'orders/sent';
    protected $model  = SentOrder::class;
}
