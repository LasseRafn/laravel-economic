<?php namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Invoice;

class InvoiceBuilder extends Builder
{
	protected $entity = 'invoices';
	protected $model = Invoice::class;

	public function getDrafts(array $filters = [])
	{
		return $this->get($filters, 'drafts');
	}

	public function getBooked(array $filters = [])
	{
		return $this->get($filters, 'booked');
	}

	public function getNotDue(array $filters = [])
	{
		return $this->get($filters, 'notDue');
	}

	public function getOverdue(array $filters = [])
	{
		return $this->get($filters, 'overdue');
	}

	public function getPaid(array $filters = [])
	{
		return $this->get($filters, 'paid');
	}

	public function getUnpaid(array $filters = [])
	{
		return $this->get($filters, 'unpaid');
	}

	public function getTotals(array $filters = [])
	{
		return $this->get($filters, 'totals');
	}
}