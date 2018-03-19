<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\DraftInvoice;

class DraftInvoiceBuilder extends Builder
{
    protected $entity = 'invoices/drafts';
    protected $model = DraftInvoice::class;
}
