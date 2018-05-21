<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Layout extends Model
{
    protected $entity     = 'layouts';
    protected $primaryKey = 'layoutNumber';
    protected $fillable   = [
        'layoutNumber',
        'name',
        'self',
        'deleted',
    ];
}
