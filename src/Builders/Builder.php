<?php namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class Builder
{
	private   $request;
	protected $entity;

	/** @var Model */
	protected $model;

	function __construct( Request $request )
	{
		$this->request = $request;
	}

	/**
	 * @param $id
	 *
	 * @return mixed|Model
	 */
	public function find($id)
	{//todo test
		$response = $this->request->curl->get( "/{$this->entity}/{$id}" );

		// todo check for errors and such

		$responseData     = json_decode( $response->getBody()->getContents() );

		return new $this->model($this->request, $responseData);
	}

	public function first()
	{
		$response = $this->request->curl->get( "/{$this->entity}?skippages=0&pagesize=1" );

		// todo check for errors and such

		$responseData     = json_decode( $response->getBody()->getContents() );
		$fetchedItems = $responseData->collection;

		return new $this->model($this->request, $fetchedItems[0]);
	}

	/**
	 * @return \Illuminate\Support\Collection|Model[]
	 */
	public function get()
	{
		$response = $this->request->curl->get( "/{$this->entity}" );

		// todo check for errors and such

		$responseData     = json_decode( $response->getBody()->getContents() );
		$fetchedItems = $responseData->collection;

		$items = collect( [] );
		foreach ( $fetchedItems as $item )
		{
			/** @var Model   $model */
			$model = new $this->model( $this->request, $item );

			$items->push( $model );
		}

		return $items;
	}

	/**
	 * @return \Illuminate\Support\Collection|Model[]
	 */
	public function all()
	{
		$page = 0;
		$pagesize = 500; // Yes, we could move this to 1000, but honestly I'd rather send two requests than stall their servers.
		$hasMore = true;
		$items = collect( [] );

		while($hasMore)
		{
			$response = $this->request->curl->get( "/{$this->entity}?skippages={$page}&pagesize={$pagesize}" );

			// todo check for errors and such

			$responseData     = json_decode( $response->getBody()->getContents() );
			$fetchedItems = $responseData->collection;

			if( count($fetchedItems) == 0)
			{
				$hasMore = false;

				break;
			}

			foreach ( $fetchedItems as $item )
			{
				/** @var Model   $model */
				$model = new $this->model( $this->request, $item );

				$items->push( $model );
			}

			$page++;
		}

		return $items;
	}

	public function create( $data)
	{
		$response = $this->request->curl->post( "/{$this->entity}", [
			'json' => $data
		] );

		$responseData = json_decode( $response->getBody()->getContents() );

		return new $this->model( $this->request, $responseData );
	}


}