<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Supplier;

class SupplierBuilder extends Builder
{
    protected $entity = 'suppliers';
    protected $model = Supplier::class;
}
