<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Layout extends Model
{
    protected $entity = 'layouts';
    protected $primaryKey = 'layoutNumber';

    public $layoutNumber;
    public $name;
    public $self;
    public $deleted;
}
