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
	public function find( $id )
	{//todo test
		$response = $this->request->curl->get( "/{$this->entity}/{$id}" );

		// todo check for errors and such

		$responseData = json_decode( $response->getBody()->getContents() );

		return new $this->model( $this->request, $responseData );
	}

	public function first()
	{
		$response = $this->request->curl->get( "/{$this->entity}?skippages=0&pagesize=1" );

		// todo check for errors and such

		$responseData = json_decode( $response->getBody()->getContents() );
		$fetchedItems = $responseData->collection;

		if ( count( $fetchedItems ) === 0 )
		{
			return null;
		}

		return new $this->model( $this->request, $fetchedItems[0] );
	}

	/**
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 */
	public function get( $filters = [] )
	{
		$urlFilters = '';

		if ( count( $filters ) > 0 )
		{
			$urlFilters .= '?filter=';

			$i = 1;
			foreach ( $filters as $filter )
			{
				$urlFilters .= $filter[0] . $this->switchComparison( $filter[1] ) . $this->escapeFilter( $filter[2] ); // todo fix arrays aswell ([1,2,3,...] string)

				if ( count( $filters ) > $i )
				{
					$urlFilters .= '$and:'; // todo allow $or: also
				}

				$i ++;
			}
		}

		$response = $this->request->curl->get( "/{$this->entity}{$urlFilters}" );

		// todo check for errors and such

		$responseData = json_decode( $response->getBody()->getContents() );

		$fetchedItems = $responseData->collection;

		$items = collect( [] );
		foreach ( $fetchedItems as $item )
		{
			/** @var Model $model */
			$model = new $this->model( $this->request, $item );

			$items->push( $model );
		}

		return $items;
	}

	/**
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 */
	public function all( $filters = [] )
	{
		$page     = 0;
		$pagesize = 500; // Yes, we could move this to 1000, but honestly I'd rather send two requests than stall their servers.
		$hasMore  = true;
		$items    = collect( [] );

		$urlFilters = '';

		if ( count( $filters ) > 0 )
		{
			$urlFilters .= '&filter=';

			$i = 1;
			foreach ( $filters as $filter )
			{
				$urlFilters .= $filter[0] . $this->switchComparison( $filter[1] ) . $this->escapeFilter( $filter[2] ); // todo fix arrays aswell ([1,2,3,...] string)

				if ( count( $filters ) > $i )
				{
					$urlFilters .= '$and:'; // todo allow $or: also
				}

				$i ++;
			}
		}

		while ( $hasMore )
		{
			$response = $this->request->curl->get( "/{$this->entity}?skippages={$page}&pagesize={$pagesize}{$urlFilters}" );

			// todo check for errors and such

			$responseData = json_decode( $response->getBody()->getContents() );
			$fetchedItems = $responseData->collection;

			if ( count( $fetchedItems ) == 0 )
			{
				$hasMore = false;

				break;
			}

			foreach ( $fetchedItems as $item )
			{
				/** @var Model $model */
				$model = new $this->model( $this->request, $item );

				$items->push( $model );
			}

			$page ++;
		}

		return $items;
	}

	public function create( $data )
	{
		$response = $this->request->curl->post( "/{$this->entity}", [
			'json' => $data
		] );

		$responseData = json_decode( $response->getBody()->getContents() );

		return new $this->model( $this->request, $responseData );
	}

	private function escapeFilter( $variable )
	{
		$escapedStrings = [
			"$",
			'(',
			')',
			'*',
			'[',
			']',
			',',
		];

		$urlencodedStrings = [
			'+',
			' ',
		];

		foreach ( $escapedStrings as $escapedString )
		{
			$variable = str_replace( $escapedString, '$' . $escapedString, $variable );
		}

		foreach ( $urlencodedStrings as $urlencodedString )
		{
			$variable = str_replace( $urlencodedString, urlencode( $urlencodedString ), $variable );
		}

		return $variable;
	}

	private function switchComparison( $comparison )
	{
		$newComparison = '';

		switch ( $comparison )
		{
			case '=':
			case '==':
				$newComparison = '$eq:';
				break;
			case '!=':
				$newComparison = '$ne:';
				break;
			case '>':
				$newComparison = '$gt:';
				break;
			case '>=':
				$newComparison = '$gte:';
				break;
			case '<':
				$newComparison = '$lt:';
				break;
			case '<=':
				$newComparison = '$lte:';
				break;
			case 'like':
				$newComparison = '$like:';
				break;
			case 'in':
				$newComparison = '$in:';
				break;
			case '!in':
				$newComparison = '$nin:';
				break;
			default:
				$newComparison = "${$comparison}:";
				break;
		}

		return $newComparison;
	}

}