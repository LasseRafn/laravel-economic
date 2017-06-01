<?php

namespace LasseRafn\Economic\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use LasseRafn\Economic\Exceptions\EconomicRequestException;

class Request
{
	public $curl;

	public function __construct( $agreementToken = '', $apiSecret = '' )
	{
		$this->curl = new Client( [
			'base_uri' => config( 'economic.request_endpoint' ),
			'headers'  => [
				'X-AppSecretToken'      => $apiSecret,
				'X-AgreementGrantToken' => $agreementToken,
				'Content-Type'          => 'application/json'
			]
		] );
	}

	public function handleWithExceptions( $callback )
	{
		try
		{
			return $callback();
		} catch ( ClientException $exception )
		{
			$message = $exception->getMessage();

			if ( $exception->hasResponse() )
			{
				$message = json_decode( $exception->getResponse()->getBody()->getContents() );
			}

			throw new EconomicRequestException( $message, $exception->getCode(), $exception->getPrevious() );
		} catch ( ServerException $exception )
		{
			$message = $exception->getMessage();

			if ( $exception->hasResponse() )
			{
				$message = json_decode( $exception->getResponse()->getBody()->getContents() );
			}

			throw new EconomicRequestException( $message, $exception->getCode(), $exception->getPrevious() );
		} catch ( \Exception $exception )
		{
			$message = $exception->getMessage();

			throw new EconomicRequestException( $message, $exception->getCode(), $exception->getPrevious() );
		}
	}
}