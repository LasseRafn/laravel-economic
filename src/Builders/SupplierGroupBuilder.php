<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\SupplierGroup;

class SupplierGroupBuilder extends Builder
{
    protected $entity = 'supplier-groups';
    protected $model = SupplierGroup::class;
}
