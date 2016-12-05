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


	function lol()
	{
		// fixme!
		try
		{
			$url      = config( 'pipedrive.endpoint' ) . $this->buildEntity( $entity, $id, $fields ) . '?api_token=' . $this-$this->api_token . '&start=' . $start . '&limit=' . $limit;
			$response = $this->curl->get( $url );

			return $this->getData( $response->getBody() );
		} catch ( \Exception $exception )
		{
			throw new \Exception( $exception->getMessage(), $exception->getCode() );
		}
	}
}