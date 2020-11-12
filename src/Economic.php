<?php

namespace LasseRafn\Economic;

use LasseRafn\Economic\Builders\AccountBuilder;
use LasseRafn\Economic\Builders\AccountingYearBuilder;
use LasseRafn\Economic\Builders\ArchivedOrderBuilder;
use LasseRafn\Economic\Builders\BookedInvoiceBuilder;
use LasseRafn\Economic\Builders\Builder;
use LasseRafn\Economic\Builders\ContactBuilder;
use LasseRafn\Economic\Builders\CustomerBuilder;
use LasseRafn\Economic\Builders\CustomerGroupBuilder;
use LasseRafn\Economic\Builders\DraftInvoiceBuilder;
use LasseRafn\Economic\Builders\DraftOrderBuilder;
use LasseRafn\Economic\Builders\EmployeeBuilder;
use LasseRafn\Economic\Builders\JournalBuilder;
use LasseRafn\Economic\Builders\LayoutBuilder;
use LasseRafn\Economic\Builders\PaidInvoiceBuilder;
use LasseRafn\Economic\Builders\PaymentTermBuilder;
use LasseRafn\Economic\Builders\ProductBuilder;
use LasseRafn\Economic\Builders\ProductGroupBuilder;
use LasseRafn\Economic\Builders\SelfBuilder;
use LasseRafn\Economic\Builders\SentOrderBuilder;
use LasseRafn\Economic\Builders\SupplierBuilder;
use LasseRafn\Economic\Builders\SupplierGroupBuilder;
use LasseRafn\Economic\Builders\UnitBuilder;
use LasseRafn\Economic\Builders\UserBuilder;
use LasseRafn\Economic\Builders\VatZoneBuilder;
use LasseRafn\Economic\Builders\VoucherBuilder;
use LasseRafn\Economic\Models\CompanySelf;
use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class Economic
{
    protected $request;

    protected $agreement;

    protected $apiSecret;

    protected $apiPublic;

    protected $stripNullValues;

    public function __construct($agreement = null, $apiSecret = null, $apiPublic = null, $stripNull = null)
    {
        $this->agreement = $agreement ?? config('economic.agreement');
        $this->apiSecret = $apiSecret ?? config('economic.secret_token');
        $this->apiPublic = $apiPublic ?? config('economic.public_token');
        $this->stripNullValues = $stripNull ?? config('economic.strip_null', false);

        $this->initRequest();
    }

    public function setAgreement($agreement = '')
    {
        $this->agreement = $agreement;

        $this->initRequest();

        return $this;
    }

    public function setApiSecret($apiSecret = '')
    {
        $this->apiSecret = $apiSecret;

        $this->initRequest();

        return $this;
    }

    public function setApiPublicToken($apiPublic = '')
    {
        $this->apiPublic = $apiPublic;

        return $this;
    }

    public function getApiTokenFromUrl()
    {
        return $_GET['token'] ?? null;
    }

    public function getAuthUrl($redirectUrl = '')
    {
        if ($redirectUrl !== '') {
            $redirectUrl = '&redirectUrl='.urlencode($redirectUrl);
        }

        return config('economic.auth_endpoint').$this->apiPublic.$redirectUrl;
    }

    /**
     * @return CustomerBuilder|Builder
     */
    public function customers()
    {
        return new CustomerBuilder($this->request);
    }

    /**
     * @return AccountBuilder()|Builder
     */
    public function accounts()
    {
        return new AccountBuilder($this->request);
    }

    /**
     * @deprecated use suppliers() instead
     *
     * @return SupplierBuilder()|Builder
     */
    public function experimentalSuppliers()
    {
        return $this->suppliers();
    }

    /**
     * @return SupplierBuilder()|Builder
     */
    public function suppliers()
    {
        return new SupplierBuilder($this->request);
    }

    /**
     * This endpoint is experimental.
     *
     * @return JournalBuilder()|Builder
     */
    public function experimentalJournals()
    {
        return new JournalBuilder($this->request);
    }

    /**
     * This endpoint is not yet documented by the API team.
     *
     * @return SupplierGroupBuilder()|Builder
     */
    public function experimentalSupplierGroups()
    {
        return new SupplierGroupBuilder($this->request);
    }

    /**
     * @return CustomerGroupBuilder|Builder
     */
    public function customersGroups()
    {
        return new CustomerGroupBuilder($this->request);
    }

    /**
     * @return LayoutBuilder|Builder
     */
    public function layouts()
    {
        return new LayoutBuilder($this->request);
    }

	/**
	 * @param integer $customerNumber
	 *
	 * @return ContactBuilder()|Builder
	 */
	public function customerContacts( $customerNumber )
	{
		return new ContactBuilder( $this->request, $customerNumber );
	}

    /**
     * @return VatZoneBuilder|Builder
     */
    public function vatZones()
    {
        return new VatZoneBuilder($this->request);
    }

    /**
     * @return VatZoneBuilder|Builder
     */
    public function paymentTerms()
    {
        return new PaymentTermBuilder($this->request);
    }

    /**
     * @return DraftInvoiceBuilder|Builder
     */
    public function draftInvoices()
    {
        return new DraftInvoiceBuilder($this->request);
    }

    /**
     * @return BookedInvoiceBuilder|Builder
     */
    public function bookedInvoices()
    {
        return new BookedInvoiceBuilder($this->request);
    }

    /**
     * @return PaidInvoiceBuilder|Builder
     */
    public function paidInvoices()
    {
        return new PaidInvoiceBuilder($this->request);
    }

    /**
     * @return ProductBuilder()|Builder
     */
    public function products()
    {
        return new ProductBuilder($this->request);
    }

    /**
     * @return ProductGroupBuilder()|Builder
     */
    public function productGroups()
    {
        return new ProductGroupBuilder($this->request);
    }

    /**
     * @return UnitBuilder()|Builder
     */
    public function units()
    {
        return new UnitBuilder($this->request);
    }

    /**
     * @return EmployeeBuilder()|Builder
     */
    public function employees()
    {
        return new EmployeeBuilder($this->request);
    }

    /**
     * @return UserBuilder()|Builder
     *
     * WARNING: Undocumented endpoint!
     */
    public function users()
    {
        return new UserBuilder($this->request);
    }

    /**
     * @return \LasseRafn\Economic\Builders\ArchivedOrderBuilder
     */
    public function archivedOrders()
    {
        return new ArchivedOrderBuilder( $this->request );
    }

	/**
	 * @return CompanySelf|Model
	 */
	public function self() {
		return ( new SelfBuilder( $this->request ) )->find( '' );
	}
    /**
     * @return \LasseRafn\Economic\Builders\SentOrderBuilder
     */
    public function sentOrders()
    {
        return new SentOrderBuilder( $this->request );
    }

    /**
     * @return DraftOrderBuilder
     */
    public function draftOrders()
    {
        return new DraftOrderBuilder($this->request);
    }

    /**
     * @param int|null $year
     *
     * @return AccountingYearBuilder()|Builder
     */
    public function accountingYear($year = null)
    {
        if ($year === null) {
            $year = (int) date('Y');
        }

        return new AccountingYearBuilder($this->request, $year);
    }

    /**
     * @param int|null $year
     *
     * @return VoucherBuilder()|Builder
     */
    public function accountingYearVouchers($year = null)
    {
        if ($year === null) {
            $year = (int) date('Y');
        }

        return new VoucherBuilder($this->request, $year);
    }

    public function downloadInvoice($directUrl)
    {
        return $this->request->curl->get($directUrl)->getBody()->getContents();
    }

    protected function initRequest()
    {
        $this->request = new Request($this->agreement, $this->apiSecret, $this->stripNullValues);
    }
}
