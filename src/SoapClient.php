<?php

namespace LasseRafn\Economic;

use Artisaninweb\SoapWrapper\Service;
use Artisaninweb\SoapWrapper\SoapWrapper;
use LasseRafn\Economic\Models\Order;

class SoapClient
{
	public $soap;

	public function __construct( $agreement = '', $apiSecret = null, $account = null ) {
		$secret = $apiSecret ?: config( 'economic.secret_token' );

		$this->soap = new SoapWrapper();
		$this->soap->add( 'economic', function ( Service $service ) use ( $agreement, $secret ) {
			$service->wsdl( 'https://api.e-conomic.com/secure/api1/EconomicWebservice.asmx?WSDL' )
			        ->trace( true )
			        ->header( 'X', 'EconomicAppIdentifier', 'BizzItsperfectEconomic/1.0 (https://bizzz.dk//; lra@bizzz.dk) BizzItsperfectEconomic/1.1' );
		} );

		$this->soap->call( 'economic.ConnectWithToken', [
			'ConnectWithToken' => [
				'token'          => $agreement,
				'appSecretToken' => $secret,
				'appToken'       => $secret
			]
		] );
	}

	public function getPayments( $toDate = null ) {
		$items = $this->getAllOpenDebtorEntries()->where( 'Type', '=', 'DebtorPayment' );

		if ( $toDate !== null ) {
			$items = $items->where( 'Date', '<=', $toDate );
		}

		return $items;
	}

	public function postOrder( Order $order ) {
		return $this->soap->call( 'economic.Order_CreateFromData', [
			'Order_CreateFromData' => [
				'data' => $order->format()
			]
		] )->Order_CreateFromDataResult;
	}

	public function getAllOpenDebtorEntries() {
		$openEntries = $this->soap->call( 'economic.DebtorEntry_GetAllOpenEntries' )->DebtorEntry_GetAllOpenEntriesResult;

		$entries = collect( [] );

		if ( ! isset( $openEntries->DebtorEntryHandle ) ) {
			return $entries;
		}

		$openEntries = $openEntries->DebtorEntryHandle;

		$handles = [];
		foreach ( $openEntries as $openEntry ) {
			if ( ! isset( $openEntry->SerialNumber ) ) {
				continue;
			}

			$handles[] = [ 'SerialNumber' => $openEntry->SerialNumber ];
		}

		if ( count( $handles ) > 0 ) {
			try {
				$entryResponse = $this->soap->call( 'economic.DebtorEntry_GetDataArray', [
					'DebtorEntry_GetDataArray' => [
						'entityHandles' => $handles
					]
				] )->DebtorEntry_GetDataArrayResult;
			} catch ( \SoapFault $exception ) {
				ErrorLog::logFor( $this->account, $exception->getMessage() );
				throw $exception;
			}

			if ( isset( $entryResponse->DebtorEntryData ) ) {
				foreach ( $entryResponse->DebtorEntryData as $item ) {
					$entries->push( $item );
				}
			}
		}

		return $entries;
	}

    public function getAllCashbooksEntries()
    {
        $cashbooks = $this->soap->call( 'economic.CashBook_GetAll' )->CashBook_GetAllResult;

        $entries = collect( [] );

        if ( !isset( $cashbooks->CashBookHandle ) ) {
            return $entries;
        }

        $cashbooks = $cashbooks->CashBookHandle;

        $handles = [];
        foreach ( $cashbooks as $cashbook ) {
            if ( !isset( $cashbook->Number ) ) {
                continue;
            }

            $handles[] = [ 'Number' => $cashbook->Number ];
        }

        if ( count( $handles ) > 0 ) {
            try {
                $cashbookResponse = $this->soap->call( 'economic.CashBook_GetDataArray', [
                    'CashBook_GetDataArray' => [
                        'entityHandles' => $handles,
                    ],
                ] )->CashBook_GetDataArrayResult;
            } catch ( \SoapFault $exception ) {
                ErrorLog::logFor( $this->account, $exception->getMessage() );
                throw $exception;
            }

            if ( isset( $cashbookResponse->CashBookData ) ) {
                foreach ( $cashbookResponse->CashBookData as $item ) {
                    $entries->push( $item );
                }
            }
        }

        return $entries;
    }
}
