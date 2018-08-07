<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class CustomerGroup extends Model
{
    protected $entity = 'customer-groups';
    protected $primaryKey = 'customerGroupNumber';
    protected $puttable = [
        'customerGroupNumber',
        'name',
    ];

    public $customerGroupNumber;
    public $name;
    public $self;
}
