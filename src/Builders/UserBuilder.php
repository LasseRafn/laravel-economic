<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\User;

class UserBuilder extends Builder
{
    protected $entity = 'users';
    protected $model = User::class;
}
