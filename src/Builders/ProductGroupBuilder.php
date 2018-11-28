<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\ProductGroup;

class ProductGroupBuilder extends Builder
{
    protected $entity = 'product-groups';
    protected $model = ProductGroup::class;
}
