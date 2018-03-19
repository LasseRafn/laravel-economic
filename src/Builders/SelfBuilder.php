<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\CompanySelf;

class SelfBuilder extends Builder
{
    protected $entity = 'self';
    protected $model = CompanySelf::class;
}
