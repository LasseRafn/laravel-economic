<?php

namespace LasseRafn\Economic\Models\Soap;

class Order
{
    public $Handle;
    public $Id;
    public $DebtorHandle;
    public $ProjectHandle;
    public $DebtorName;
    public $DebtorAddress;
    public $DebtorPostalCode;
    public $DebtorCity;
    public $DebtorCountry;
    public $DebtorEan;
    public $PublicEntryNumber;
    public $AttentionHandle;
    public $YourReferenceHandle;
    public $OurReferenceHandle;
    public $OurReference2Handle;
    public $Date;
    public $TermOfPaymentHandle;
    public $DueDate;
    public $CurrencyHandle;
    public $ExchangeRate;
    public $IsVatIncluded;
    public $LayoutHandle;
    public $DeliveryLocationHandle;
    public $DeliveryAddress;
    public $DeliveryPostalCode;
    public $DeliveryCity;
    public $DeliveryCountry;
    public $TermsOfDelivery;
    public $DeliveryDate;
    public $Heading;
    public $TextLine1;
    public $TextLine2;
    public $OtherReference;
    public $IsArchived;
    public $IsSent;
    public $NetAmount;
    public $VatAmount;
    public $GrossAmount;
    public $Margin;
    public $MarginAsPercent;
    public $RoundingAmount;
    public $DebtorCounty;
    public $DeliveryCounty;
    public $VatZone;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function format()
    {
        return [
            'Id'                  => $this->Id,
            'Number'              => $this->Handle,
            'Handle'              => ['Id' => (int) $this->Handle],
            'DebtorHandle'        => ['Number' => (string) $this->DebtorHandle],
            'DebtorName'          => $this->DebtorName,
            'DebtorAddress'       => trim($this->DebtorAddress),
            'DebtorPostalCode'    => $this->DebtorPostalCode,
            'DebtorCity'          => $this->DebtorCity,
            'DebtorCountry'       => $this->DebtorCountry,
            'Date'                => date('Y-m-d\TH:i:s', strtotime($this->Date)),
            'TermOfPaymentHandle' => ['Id' => (int) $this->TermOfPaymentHandle],
            'DueDate'             => date('Y-m-d\TH:i:s', strtotime($this->DueDate)),
            'CurrencyHandle'      => ['Code' => (string) $this->CurrencyHandle],
            'ExchangeRate'        => $this->ExchangeRate,
            'IsVatIncluded'       => $this->IsVatIncluded,
            'LayoutHandle'        => ['Id' => (int) $this->LayoutHandle],
            'DeliveryAddress'     => $this->DeliveryAddress,
            'DeliveryPostalCode'  => $this->DeliveryPostalCode,
            'DeliveryCity'        => $this->DeliveryCity,
            'DeliveryCountry'     => $this->DeliveryCountry,
            'DeliveryDate'        => date('Y-m-d\TH:i:s', strtotime($this->DeliveryDate)),
            //			'Heading'                => $this->Heading,
            //			'TextLine1'              => $this->TextLine1,
            //			'TextLine2'              => $this->TextLine2,
            'IsArchived'          => $this->IsArchived,
            'IsSent'              => $this->IsSent,
            'NetAmount'           => $this->NetAmount,
            'VatAmount'           => $this->VatAmount,
            'GrossAmount'         => $this->GrossAmount,
            'Margin'              => (float) $this->Margin,
            'MarginAsPercent'     => (float) $this->MarginAsPercent,
            'RoundingAmount'      => (float) $this->RoundingAmount,
            'VatZone'             => ['Number' => (string) $this->VatZone],
        ];
    }
}
