<?php
/**
 * Created by PhpStorm.
 * User: kgbot
 * Date: 12/21/17
 * Time: 10:12 PM
 */

namespace App\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class PaidInvoice extends Model
{
    protected $entity     = 'invoices/paid';
    protected $primaryKey = 'bookedInvoiceNumber';
    protected $fillable   = [
        'bookedInvoiceNumber',
        'self',
        'pdf',
        'dueDate',
        'date',
        'currency',
        'customer',
        'layout',
        'paymentTerms',
        'recipient',
        'lines',
        'project',
        'notes',
        'references',
        'grossAmount',
        'netAmount',
        'remainder',
        'remainderInBaseCurrency',
    ];

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