<?php

namespace App\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class PaidInvoice extends Model
{
    protected $entity = 'invoices/paid';
    protected $primaryKey = 'bookedInvoiceNumber';

    public $bookedInvoiceNumber;
    public $self;
    public $pdf;
    public $name;
    public $references;
    public $dueDate;
    public $date;
    public $currency;
    public $recipient;
    public $project;
    public $grossAmount;
    public $netAmount;
    public $remainder;
    public $remainderInBaseCurrency;

    /** @var Customer */
    public $customer;

    /** @var \stdClass|array */
    public $notes;

    /** @var Layout */
    public $layout;

    /** @var PaymentTerm */
    public $paymentTerms;

    /** @var array */
    public $lines;
}
