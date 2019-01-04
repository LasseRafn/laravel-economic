<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ArchivedOrder extends Model
{
    public    $orderNumber;
    public    $name;
    protected $entity     = ' /orders/archived';
    protected $primaryKey = 'orderNumber';
}
