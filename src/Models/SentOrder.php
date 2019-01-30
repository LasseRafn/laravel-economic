<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class SentOrder extends Model
{
    public    $orderNumber;
    public    $name;
    protected $entity     = ' /orders/sent';
    protected $primaryKey = 'orderNumber';
}
