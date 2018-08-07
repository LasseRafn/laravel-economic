<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class AccountingYear extends Model
{
    protected $entity = ' /accounting-years/:accountingYear';
    protected $primaryKey = 'accountingYear';

    public $attachment;
    public $booked;
    public $date;
    public $dueDate;
    public $lines;
    public $numberSeries;
    public $remainder;
    public $remainderInDefaultCurrency;
    public $self;
    public $voucherId;
    public $voucherNumber;
    public $voucherType;
}
