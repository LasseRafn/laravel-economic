<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Account;

class AccountBuilder extends Builder
{
    protected $entity = 'accounts';
    protected $model = Account::class;
}
