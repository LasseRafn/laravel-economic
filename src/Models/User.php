<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class User extends Model
{
    protected $entity = 'users';
    protected $primaryKey = 'userNumber';
    protected $fillable = [
        'userNumber',
        'name',
        'self',
    ];
}
