<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Unit;

class UnitBuilder extends Builder
{
    protected $entity = 'units';
    protected $model = Unit::class;
}
