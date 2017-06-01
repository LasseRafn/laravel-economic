<?php namespace LasseRafn\Economic\Exceptions;

class  EconomicRequestException extends \Exception
{
	public function getExceptionFromJson()
	{
		return json_decode( $this->getMessage() )->message;
	}
}