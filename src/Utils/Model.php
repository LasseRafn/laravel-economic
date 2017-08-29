<?php namespace LasseRafn\Economic\Utils;

class Model
{
	protected $entity;
	protected $primaryKey;
	protected $modelClass = self::class;
	protected $fillable   = [];

	/**
	 * @var Request
	 */
	protected $request;

	public function __construct( Request $request, $data = [] )
	{
		$this->request = $request;

		$data = (array) $data;

		foreach ( $data as $key => $value )
		{
			$customSetterMethod = 'set' . ucfirst( camel_case( $key ) ) . 'Attribute';

			if ( ! method_exists( $this, $customSetterMethod ) )
			{
				$this->setAttribute( $key, $value );
			}
			else
			{
				$this->setAttribute( $key, $this->{$customSetterMethod}( $value ) );
			}
		}
	}

	public function __toString()
	{
		return json_encode( $this->toArray() );
	}

	public function toArray()
	{
		$data = [];

		foreach ( $this->fillable as $fillable )
		{
			if ( isset( $this->{$fillable} ) )
			{
				$data[ $fillable ] = $this->{$fillable};
			}
		}

		return $data;
	}

	protected function setAttribute( $attribute, $value )
	{
		$this->{$attribute} = $value;
	}

	public function delete()
	{
		return $this->request->handleWithExceptions( function ()
		{
			return $this->request->curl->delete( "/{$this->entity}/{$this->{$this->primaryKey}}" );
		} );
	}

	public function update( $data = [] )
	{
		$data = array_merge($this->toArray(), $data);

		return $this->request->handleWithExceptions( function () use ( $data )
		{
			$response = $this->request->curl->put( "/{$this->entity}/{$this->{$this->primaryKey}}", [
				'json' => $data
			] );

			$responseData = json_decode( $response->getBody()->getContents() );

			return new $this->modelClass( $this->request, $responseData );
		} );
	}
}