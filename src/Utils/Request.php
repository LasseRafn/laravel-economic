<?php
namespace LasseRafn\Economic\Utils;

use GuzzleHttp\Client;

class Request
{
	public    $curl;

	public function __construct($agreementToken = '')
	{
		$this->curl = new Client( [
			'base_uri' => config('economic.request_endpoint'),
		    'headers' => [
		    	'X-AppSecretToken' => config('economic.secret_token'),
		        'X-AgreementGrantToken' => $agreementToken,
		        'Content-Type' => 'application/json'
		    ]
		] );
	}
}