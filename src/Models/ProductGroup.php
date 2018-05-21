<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ProductGroup extends Model
{
    protected $entity     = 'product-groups';
    protected $primaryKey = 'productGroupNumber';
    protected $fillable   = [
        'productGroupNumber',
        'name',
        'self',
        'salesAccounts',
        'inventoryEnabled',
        'accrual',
    ];
}
