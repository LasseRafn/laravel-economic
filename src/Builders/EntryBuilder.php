<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Entry;

class EntryBuilder extends SingleBuilder
{
    protected $entity = 'entries';
    protected $model = Entry::class;
}
