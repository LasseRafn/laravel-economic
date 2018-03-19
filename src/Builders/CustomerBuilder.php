<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Customer;

class CustomerBuilder extends Builder
{
    protected $entity = 'customers';
    protected $model = Customer::class;
}
