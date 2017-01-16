<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class DraftInvoice extends Model
{
	protected $entity     = 'invoices/drafts';
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
		'project',
		'notes'
	];

	public $draftInvoiceNumber;
	public $self;
	public $pdf;
	public $name;
	public $dueDate;
	public $date;
	public $currency;
	public $recipient;
	public $project;

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

	/**
	 * @param string $description
	 * @param int    $quantity
	 * @param        $product
	 */
	public function addLine( $description = '', $quantity = 1, $product )
	{
		$line = new \stdClass();

		$line->description    = $description;
		$line->quantity       = $quantity;
		$line->product        = $product;
		$line->unitNetPrice   = $product->salesPrice;
		$line->unitCostPrice  = $product->costPrice;
		$line->totalNetAmount = $quantity * $product->salesPrice;

		if ( isset( $product->unit ) )
		{
			$line->unit = $product->unit;
		}

		$this->lines[] = $line;
	}

	public function book( $number = null )
	{
		$data = [
			'draftInvoice' => [
				'self'               => $this->self,
				'draftInvoiceNumber' => $this->draftInvoiceNumber
			]
		];

		if ( $number !== null )
		{
			$data['bookWithNumber'] = $number;
		}

		return $this->request->curl->post( 'invoices/booked', [
			'json' => $data
		] );
	}
}