<?php namespace LasseRafn\Economic;

use LasseRafn\Economic\Builders\BookedInvoiceBuilder;
use LasseRafn\Economic\Builders\Builder;
use LasseRafn\Economic\Builders\CustomerBuilder;
use LasseRafn\Economic\Builders\CustomerGroupBuilder;
use LasseRafn\Economic\Builders\DraftInvoiceBuilder;
use LasseRafn\Economic\Builders\EmployeeBuilder;
use LasseRafn\Economic\Builders\EntryBuilder;
use LasseRafn\Economic\Builders\LayoutBuilder;
use LasseRafn\Economic\Builders\PaymentTermBuilder;
use LasseRafn\Economic\Builders\ProductBuilder;
use LasseRafn\Economic\Builders\ProductGroupBuilder;
use LasseRafn\Economic\Builders\SingleBuilder;
use LasseRafn\Economic\Builders\UnitBuilder;
use LasseRafn\Economic\Builders\VatZoneBuilder;
use LasseRafn\Economic\Utils\Request;

class Economic
{
	protected $request;

	public function __construct( $agreement = '' )
	{
		$this->request = new Request( $agreement );
	}

	public function getApiTokenFromUrl()
	{
		return $_GET['token'] ?? null;
	}

	public function getAuthUrl( $redirectUrl = '' )
	{
		if ( $redirectUrl !== '' )
		{
			$redirectUrl = urlencode( $redirectUrl );
			$redirectUrl = "&redirectUrl={$redirectUrl}";
		}

		return config( 'economic.auth_endpoint' ) . config( 'economic.public_token' ) . $redirectUrl;
	}

	/**
	 * @return CustomerBuilder|Builder
	 */
	public function customers()
	{
		return new CustomerBuilder( $this->request );
	}

	/**
	 * @return CustomerGroupBuilder|Builder
	 */
	public function customersGroups()
	{
		return new CustomerGroupBuilder( $this->request );
	}

	/**
	 * @return LayoutBuilder|Builder
	 */
	public function layouts()
	{
		return new LayoutBuilder( $this->request );
	}

	/**
	 * @return VatZoneBuilder|Builder
	 */
	public function vatZones()
	{
		return new VatZoneBuilder( $this->request );
	}

	/**
	 * @return VatZoneBuilder|Builder
	 */
	public function paymentTerms()
	{
		return new PaymentTermBuilder( $this->request );
	}

	/**
	 * @return DraftInvoiceBuilder|Builder
	 */
	public function draftInvoices()
	{
		return new DraftInvoiceBuilder( $this->request );
	}

	/**
	 * @return BookedInvoiceBuilder|Builder
	 */
	public function bookedInvoices()
	{
		return new BookedInvoiceBuilder( $this->request );
	}

	/**
	 * @return ProductBuilder()|Builder
	 */
	public function products()
	{
		return new ProductBuilder( $this->request );
	}

	/**
	 * @return ProductGroupBuilder()|Builder
	 */
	public function productGroups()
	{
		return new ProductGroupBuilder( $this->request );
	}

	/**
	 * @return UnitBuilder()|Builder
	 */
	public function units()
	{
		return new UnitBuilder( $this->request );
	}

	/**
	 * @return EmployeeBuilder()|Builder
	 */
	public function employees()
	{
		return new EmployeeBuilder( $this->request );
	}

	/**
	 * @return EntryBuilder()|SingleBuilder
	 */
	public function entries()
	{
		return new EntryBuilder( $this->request );
	}
}