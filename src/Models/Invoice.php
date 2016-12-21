<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Invoice extends Model
{
	protected $entity     = 'invoices';
	protected $primaryKey = 'draftInvoiceNumber';
	protected $fillable   = [
		'draftInvoiceNumber',
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
	];

	public $draftInvoiceNumber;
	public $self;
	public $pdf;
	public $name;
	public $dueDate;
	public $date;
	public $currency;
	public $recipient;

	/** @var Customer */
	public $customer;

	/** @var Layout */
	public $layout;

	/** @var PaymentTerm */
	public $paymentTerms;

	/** @var array */
	public $lines;

	/**
	 * @param string $description
	 * @param int    $quantity
	 * @param        $product
	 * @param        $unit
	 */
	public function addLine( $description = '', $quantity = 1, $product, $unit )
	{
		$this->lines[] = [
			'description' => $description,
			'quantity'    => $quantity,
			'product'     => $product,
			'unit'        => $unit
		];
	}
}