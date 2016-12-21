<?php namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Invoice;

class InvoiceBuilder extends Builder
{
	protected $entity = 'invoices';
	protected $model = Invoice::class;
}