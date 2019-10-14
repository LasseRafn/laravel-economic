<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\DraftOrder;

class DraftOrderBuilder extends Builder
{
    protected $entity = 'orders/drafts';
    protected $model = DraftOrder::class;
}
