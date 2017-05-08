<?php
namespace LasseRafn\Economic\Utils;

use GuzzleHttp\Client;

class Request
{
	public    $curl;

	public function __construct($agreementToken = '', $apiSecret = '')
	{
		$this->curl = new Client( [
			'base_uri' => config('economic.request_endpoint'),
		    'headers' => [
		    	'X-AppSecretToken' => $apiSecret,
		        'X-AgreementGrantToken' => $agreementToken,
		        'Content-Type' => 'application/json'
		    ]
		] );
	}
}