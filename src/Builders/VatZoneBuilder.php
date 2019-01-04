<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\VatZone;

class VatZoneBuilder extends Builder
{
    protected $entity = 'vat-zones';
    protected $model = VatZone::class;
}
