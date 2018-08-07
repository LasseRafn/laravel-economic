<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class User extends Model
{
    protected $entity = 'users';
    protected $primaryKey = 'userNumber';

    public $userNumber;
    public $name;
    public $self;
}
