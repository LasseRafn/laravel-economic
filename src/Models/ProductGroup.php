<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ProductGroup extends Model
{
    protected $entity = 'product-groups';
    protected $primaryKey = 'productGroupNumber';

    public $productGroupNumber;
    public $name;
    public $self;
    public $salesAccounts;
    public $inventoryEnabled;
    public $accrual;
}
