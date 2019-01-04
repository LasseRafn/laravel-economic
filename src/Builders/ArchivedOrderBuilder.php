<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\ArchivedOrder;

class ArchivedOrderBuilder extends Builder
{
    protected $entity = 'orders/archived';
    protected $model  = ArchivedOrder::class;
}
