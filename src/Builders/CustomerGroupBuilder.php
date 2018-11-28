<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\CustomerGroup;

class CustomerGroupBuilder extends Builder
{
    protected $entity = 'customer-groups';
    protected $model = CustomerGroup::class;
}
