<?php

namespace LasseRafn\Economic\Utils;

class Model
{
	protected $entity;
	protected $primaryKey;
	protected $modelClass = self::class;

	/**
	 * @var Request
	 */
	protected $request;

	public function __construct( Request $request, $data = [] ) {
		$this->request = $request;

		$data = (array) $data;

		foreach ( $data as $key => $value ) {
			$customSetterMethod = 'set' . ucfirst( camel_case( $key ) ) . 'Attribute';

			if ( ! method_exists( $this, $customSetterMethod ) ) {
				$this->setAttribute( $key, $value );
			} else {
				$this->setAttribute( $key, $this->{$customSetterMethod}( $value ) );
			}
		}
	}

	public function __toString() {
		return json_encode( $this->toArray() );
	}

	public function toArray() {
		$data       = [];
		$class      = new \ReflectionObject( $this );
		$properties = $class->getProperties( \ReflectionProperty::IS_PUBLIC );

		/** @var \ReflectionProperty $property */
		foreach ( $properties as $property ) {
			$data[ $property->getName() ] = $this->{$property->getName()};
		}

		return $data;
	}

	/**
	 * Returns an array of data that will be used for PUT/update requests towards this model.
	 *
	 * @param array $overrides
	 *
	 * @return array
	 */
	public function toPutArray( $overrides = [] ) {
		if ( isset( $this->puttable ) ) {
			return array_merge( array_only(
				$this->toArray(),
				$this->puttable
			), $overrides );
		}

		return array_merge( $this->toArray(), $overrides );
	}

	protected function setAttribute( $attribute, $value ) {
		$this->{$attribute} = $value;
	}

	public function delete() {
		return $this->request->handleWithExceptions( function () {
			return $this->request->curl->delete( "/{$this->entity}/{$this->{$this->primaryKey}}" );
		} );
	}

	public function update( $data = [] ) {
		return $this->updateRaw( $this->toPutArray( $data ) );
	}

	public function updateRaw( $data = [] ) {
		return $this->request->handleWithExceptions( function () use ( $data ) {
			$response = $this->request->curl->put( $this->getUpdateEndpoint(), [
				'json' => $data,
			] );

			$responseData = json_decode( $response->getBody()->getContents() );

			return new $this->modelClass( $this->request, $responseData );
		} );
	}

	protected function getUpdateEndpoint() {
		return "/{$this->entity}/{$this->{$this->primaryKey}}";
	}
}
