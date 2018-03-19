<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Journal;

class JournalBuilder extends Builder
{
    protected $entity = 'journals-experimental';
    protected $model = Journal::class;
}
