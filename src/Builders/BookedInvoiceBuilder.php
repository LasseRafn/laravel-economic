<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\BookedInvoice;

class BookedInvoiceBuilder extends Builder
{
    protected $entity = 'invoices/booked';
    protected $model = BookedInvoice::class;
}
