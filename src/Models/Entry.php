<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Entry extends Model
{
    protected $entity     = 'entries';
    protected $primaryKey = 'entryNumber';
    protected $fillable   = [
        'entryNumber',
        'account',
        'amount',
        'amountInBaseCurrency',
        'currency',
        'date',
        'departmentalDistribution',
        'entryType',
        'project',
        'self',
        'text',
        'vatAccount',
        'voucherNumber',
    ];

    public $entryNumber;
    public $account;
    public $amount;
    public $amountInBaseCurrency;
    public $currency;
    public $date;
    public $departmentalDistribution;
    public $entryType;
    public $project;
    public $self;
    public $text;
    public $vatAccount;
    public $voucherNumber;
}
