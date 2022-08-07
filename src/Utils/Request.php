<?php

namespace LasseRafn\Economic\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use LasseRafn\Economic\Exceptions\EconomicClientException;
use LasseRafn\Economic\Exceptions\EconomicRequestException;

class Request
{
	public $curl;

	protected $stripNull;

	public $beforeRequestHooks = [];

	public function __construct($agreementToken = '', $apiSecret = '', $stripNull = false)
	{
		$this->curl = new Client([
			'base_uri'        => config('economic.request_endpoint'),
			'headers'         => [
				'X-AppSecretToken'      => $apiSecret,
				'X-AgreementGrantToken' => $agreementToken,
				'Content-Type'          => 'application/json',
			],
			'allow_redirects' => ['strict' => true],
		]);

		$this->stripNull = $stripNull;
	}

	public function formatData($data)
	{
		if ($this->stripNull) {
			return array_filter($data, static function ($item) { return $item !== null; });
		}

		return $data;
	}

	public function handleWithExceptions($callback)
	{
		try {
			return $callback();
		} catch (ClientException $exception) {
			$message = $exception->getMessage();
			$code    = $exception->getCode();

			if ($exception->hasResponse()) {
				$message = $exception->getResponse()->getBody()->getContents();
				$code    = $exception->getResponse()->getStatusCode();
			}

			throw new EconomicRequestException($message, $code);
		} catch (ServerException $exception) {
			$message = $exception->getMessage();
			$code    = $exception->getCode();

			if ($exception->hasResponse()) {
				$message = $exception->getResponse()->getBody()->getContents();
				$code    = $exception->getResponse()->getStatusCode();
			}

			throw new EconomicRequestException($message, $code);
		} catch (\Exception $exception) {
			$message = $exception->getMessage();
			$code    = $exception->getCode();

			throw new EconomicClientException($message, $code);
		}
	}

	public function doRequest($method, $path, $options = [])
	{
		try {
			foreach ($this->beforeRequestHooks as $hook) {
				$hook($method, $path, $options);
			}
		} catch (\Throwable $exception) {
			// silence hooks!!!
		}

		if (filter_var(config('economic.retry_server_exceptions.enabled'), FILTER_VALIDATE_BOOLEAN)) {
			return retry(config('economic.retry_server_exceptions.retries', 3), function () use ($method, $path, $options) {
				return $this->curl->{$method}($path, $options);
			}, config('economic.retry_server_exceptions.timeout_ms', 10000), function (\Throwable $throwable) { return $throwable->getCode() >= 500 && $throwable->getCode() <= 599; });
		}

		return $this->curl->{$method}($path, $options);
	}
}
