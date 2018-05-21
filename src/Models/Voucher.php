<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Voucher extends Model
{
    protected $entity = ' /accounting-years/:accountingYear/vouchers';
    protected $primaryKey = 'voucherNumber';
    protected $fillable = [
        'attachment',
        'booked',
        'date',
        'dueDate',
        'lines',
        'numberSeries',
        'remainder',
        'remainderInDefaultCurrency',
        'self',
        'voucherId',
        'voucherNumber',
        'voucherType',
    ];

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
