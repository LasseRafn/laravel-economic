<?php

namespace LasseRafn\Economic;

use Artisaninweb\SoapWrapper\Service;
use Artisaninweb\SoapWrapper\SoapWrapper;
use LasseRafn\Economic\Models\Soap\Order;

class SoapClient
{
    public $soap;
    protected $secret;
    protected $agreement;

    public function __construct($agreement = '', $secret = null)
    {
        $this->agreement = $agreement ?? config('economic.agreement');
        $this->secret = $secret ?? config('economic.secret_token');
    }

    public function auth($agreement = null, $secret = null)
    {
        $agreement = $agreement ?? $this->agreement;
        $secret = $secret ?? $this->secret;

        $this->soap = new SoapWrapper();
        $this->soap->add('economic', function (Service $service) {
            $service->wsdl('https://api.e-conomic.com/secure/api1/EconomicWebservice.asmx?WSDL')
                    ->trace(true)
                    ->header('X', 'EconomicAppIdentifier', 'e-conomic Soap API');
        });

        $this->soap->call('economic.ConnectWithToken', [
            'ConnectWithToken' => [
                'token'          => $agreement,
                'appSecretToken' => $secret,
                'appToken'       => $secret,
            ],
        ]);

        return $this;
    }

    public function getPayments($toDate = null)
    {
        $items = $this->getAllOpenDebtorEntries()->where('Type', '=', 'DebtorPayment');

        if ($toDate !== null) {
            $items = $items->where('Date', '<=', $toDate);
        }

        return $items;
    }

    public function postOrder(Order $order)
    {
        return $this->soap->call('economic.Order_CreateFromData', [
            'Order_CreateFromData' => [
                'data' => $order->format(),
            ],
        ])->Order_CreateFromDataResult;
    }

    public function getAllOpenDebtorEntries()
    {
        $openEntries = $this->soap->call('economic.DebtorEntry_GetAllOpenEntries')->DebtorEntry_GetAllOpenEntriesResult;

        $entries = collect([]);

        if (!isset($openEntries->DebtorEntryHandle)) {
            return $entries;
        }

        $openEntries = $openEntries->DebtorEntryHandle;

        $handles = [];
        foreach ($openEntries as $openEntry) {
            if (!isset($openEntry->SerialNumber)) {
                continue;
            }

            $handles[] = ['SerialNumber' => $openEntry->SerialNumber];
        }

        if (count($handles) > 0) {
            try {
                $entryResponse = $this->soap->call('economic.DebtorEntry_GetDataArray', [
                    'DebtorEntry_GetDataArray' => [
                        'entityHandles' => $handles,
                    ],
                ])->DebtorEntry_GetDataArrayResult;
            } catch (\SoapFault $exception) {
                throw $exception;
            }

            if (isset($entryResponse->DebtorEntryData)) {
                foreach ($entryResponse->DebtorEntryData as $item) {
                    $entries->push($item);
                }
            }
        }

        return $entries;
    }

    public function getAllCashbooksEntries()
    {
        $cashbooks = $this->soap->call('economic.CashBook_GetAll')->CashBook_GetAllResult;

        $entries = collect([]);

        if (!isset($cashbooks->CashBookHandle)) {
            return $entries;
        }

        $cashbooks = $cashbooks->CashBookHandle;

        $handles = [];
        foreach ($cashbooks as $cashbook) {
            if (!isset($cashbook->Number)) {
                continue;
            }

            $handles[] = ['Number' => $cashbook->Number];
        }

        if (count($handles) > 0) {
            try {
                $cashbookResponse = $this->soap->call('economic.CashBook_GetDataArray', [
                    'CashBook_GetDataArray' => [
                        'entityHandles' => $handles,
                    ],
                ])->CashBook_GetDataArrayResult;
            } catch (\SoapFault $exception) {
                throw $exception;
            }

            if (isset($cashbookResponse->CashBookData)) {
                foreach ($cashbookResponse->CashBookData as $item) {
                    $entries->push($item);
                }
            }
        }

        return $entries;
    }

    public function createCahBookEntryFromData($data)
    {
        return $this->soap->call('economic.CashBookEntry_CreateFromData', [
            'CashBookEntry_CreateFromData' => [
                'data' => $data,
            ],
        ])->CashBookEntry_CreateFromDataResult;
    }

    public function createCashBookEntriesFromArray($data)
    {
        return $this->soap->call('economic.CashBookEntry_CreateFromDataArray', [
            'CashBookEntry_CreateFromDataArray' => [
                'dataArray' => $data,
            ],
        ])->CashBookEntry_CreateFromDataArrayResult;
    }

    public function createProjectsFromArray($data)
    {
        return $this->soap->call('economic.Project_CreateFromDataArray', [
            'Project_CreateFromDataArray' => [
                'dataArray' => $data,
            ],
        ])->Project_CreateFromDataArrayResult;
    }
}
