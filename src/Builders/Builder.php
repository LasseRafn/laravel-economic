<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\FilterOperators\AndOperator;
use LasseRafn\Economic\FilterOperators\EqualsOperator;
use LasseRafn\Economic\FilterOperators\FilterOperatorInterface;
use LasseRafn\Economic\FilterOperators\GreaterThanOperator;
use LasseRafn\Economic\FilterOperators\GreaterThanOrEqualOperator;
use LasseRafn\Economic\FilterOperators\InOperator;
use LasseRafn\Economic\FilterOperators\LessThanOperator;
use LasseRafn\Economic\FilterOperators\LessThanOrEqualOperator;
use LasseRafn\Economic\FilterOperators\LikeOperator;
use LasseRafn\Economic\FilterOperators\NotEqualsOperator;
use LasseRafn\Economic\FilterOperators\NotInOperator;
use LasseRafn\Economic\FilterOperators\NullOperator;
use LasseRafn\Economic\FilterOperators\OperatorNotFound;
use LasseRafn\Economic\FilterOperators\OrOperator;
use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class Builder
{
    protected $request;
    protected $entity;

    /** @var Model */
    protected $model;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

	/**
	 * @param $id
	 *
	 * @return Model
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function find($id)
    {
        return $this->request->handleWithExceptions(function () use ($id) {
            $response = $this->request->doRequest('get', "/{$this->entity}/{$id}");

            $responseData = json_decode($response->getBody()->getContents());

            return new $this->model($this->request, $responseData);
        });
    }

	/**
	 * @return Model
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function first()
    {
        return $this->request->handleWithExceptions(function () {
	        $response = $this->request->doRequest('get', "/{$this->entity}?skippages=0&pagesize=1");

            $responseData = json_decode($response->getBody()->getContents());
            $fetchedItems = $responseData->collection;

            if (count($fetchedItems) === 0) {
                return;
            }

            return new $this->model($this->request, $fetchedItems[0]);
        });
    }

	/**
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function get($filters = [])
    {
	    $urlFilters = $this->generateQueryStringFromFilterArray($filters);

        return $this->request->handleWithExceptions(function () use ($urlFilters) {
	        $response = $this->request->doRequest('get', "/{$this->entity}{$urlFilters}");

            $responseData = json_decode($response->getBody()->getContents());

            $fetchedItems = $responseData->collection;

            $items = collect([]);
            foreach ($fetchedItems as $item) {
                /** @var Model $model */
                $model = new $this->model($this->request, $item);

                $items->push($model);
            }

            return $items;
        });
    }

	/**
	 * @param int   $page
	 * @param int   $pageSize
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function getByPage($page = 0, $pageSize = 500, $filters = [])
    {
        $items = collect([]);

        $urlFilters = $this->generateQueryStringFromFilterArray($filters, true);

        return $this->request->handleWithExceptions(function () use ($pageSize, &$page, &$items, $urlFilters) {
	        $response = $this->request->doRequest('get', "/{$this->entity}?skippages={$page}&pagesize={$pageSize}{$urlFilters}");

            $responseData = json_decode($response->getBody()->getContents());
            $fetchedItems = $responseData->collection;

            foreach ($fetchedItems as $item) {
                /** @var Model $model */
                $model = new $this->model($this->request, $item);

                $items->push($model);
            }

            return $items;
        });
    }

	/**
	 * @param array $filters
	 * @param int   $pageSize
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function all($filters = [], $pageSize = 500)
    {
        $page = 0;
        $pagesize = $pageSize;
        $hasMore = true;
        $items = collect([]);

	    $urlFilters = $this->generateQueryStringFromFilterArray($filters, true);

        return $this->request->handleWithExceptions(function () use (&$hasMore, $pagesize, &$page, &$items, $urlFilters) {
            while ($hasMore) {
	            $response = $this->request->doRequest('get', "/{$this->entity}?skippages={$page}&pagesize={$pagesize}{$urlFilters}");

                $responseData = json_decode($response->getBody()->getContents());
                $fetchedItems = $responseData->collection;

                if (count($fetchedItems) === 0) {
                    $hasMore = false;

                    break;
                }

                foreach ($fetchedItems as $item) {
                    /** @var Model $model */
                    $model = new $this->model($this->request, $item);

                    $items->push($model);
                }

                $page++;
            }

            return $items;
        });
    }

	/**
	 * @param $data
	 *
	 * @return Model
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function create($data)
    {
    	$data = $this->request->formatData($data);

        return $this->request->handleWithExceptions(function () use ($data) {
	        $response = $this->request->doRequest('post', "/{$this->entity}",[
		        'json' => $data,
	        ]);

            $responseData = json_decode($response->getBody()->getContents());

            return new $this->model($this->request, $responseData);
        });
    }

	/**
	 * @param string $operator
	 *
	 * @return FilterOperatorInterface
	 *
	 * @throws OperatorNotFound
	 */
    protected function getOperator($operator)
    {
	    switch (\mb_strtolower($operator)) {
		    case '=':
		    case '==':
		    case '===':
		     return new EqualsOperator;
		    case '!=':
		    case '!==':
		        return new NotEqualsOperator;
		    case '>':
			    return new GreaterThanOperator;
		    case '>=':
			    return new GreaterThanOrEqualOperator;
		    case '<':
			    return new LessThanOperator;
		    case '<=':
			    return new LessThanOrEqualOperator;
		    case 'like':
			    return new LikeOperator;
		    case 'in':
			    return new InOperator;
		    case '!in':
		    case 'not in':
			    return new NotInOperator;
		    case 'or':
		    case 'or else':
				return new OrOperator;
		    case 'and':
			    return new AndOperator;
		    case 'null':
			    return new NullOperator;
		    default:
			    throw new OperatorNotFound($operator);
	    }
    }

    protected function generateQueryStringFromFilterArray($filters, $and = false)
    {
	    if (\count($filters) === 0) {
	    	return '';
	    }

	    $string = ($and ? '&' : '?') . 'filter=';

	    $i = 1;
	    foreach ($filters as $filter) {
	    	// To support passing in 'and' / 'or' as an individual filter rather than ['', 'and', '']
	    	if (!\is_array($filter) && \count($filter) === 1) {
			    $filterOperator = $this->getOperator($filter[0] ?? $filter);

			    if (($filterOperator instanceof OrOperator || $filterOperator instanceof AndOperator)) {
			    	$string.= $filterOperator->queryString;
			    	$i++;
			    	continue;
			    }
		    }

		    $filterOperator = $this->getOperator($filter[1]);
		    $string .= $filter[0] . $filterOperator->queryString . $this->transformFilterValue($filter[2], $filterOperator);

		    if (!($filterOperator instanceof OrOperator || $filterOperator instanceof AndOperator) && \count($filters) > $i) {
			    $string .= (new AndOperator)->queryString;
		    }

		    $i++;
	    }

	    return $string;
    }

    protected function transformFilterValue($value, FilterOperatorInterface $filterOperator)
    {
    	if($value === null) {
    	    return (new NullOperator)->queryString;
	    }

    	if ($filterOperator instanceof NullOperator || $filterOperator instanceof OrOperator || $filterOperator instanceof AndOperator ) {
    		return '';
	    }

	    if ($filterOperator instanceof InOperator && \is_array($value)) {
		    return '[' . implode(',', $value) . ']';
	    }

	    $escapedStrings = [
		    '$',
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

	    foreach ($escapedStrings as $escapedString) {
		    $value = str_replace($escapedString, '$'.$escapedString, $value);
	    }

	    foreach ($urlencodedStrings as $urlencodedString) {
		    $value = str_replace($urlencodedString, urlencode($urlencodedString), $value);
	    }

	    return $value;
    }
}
