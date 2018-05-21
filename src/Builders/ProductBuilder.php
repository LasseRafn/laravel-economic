<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Product;

class ProductBuilder extends Builder
{
    protected $entity = 'products';
    protected $model = Product::class;
}
