<?php

namespace LasseRafn\Economic\Builders;

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
     * @return mixed|Model
     */
    public function find($id)
    {
        return $this->request->handleWithExceptions(function () use ($id) {
            $response = $this->request->curl->get("/{$this->entity}/{$id}");

            $responseData = json_decode($response->getBody()->getContents());

            return new $this->model($this->request, $responseData);
        });
    }

    public function first()
    {
        return $this->request->handleWithExceptions(function () {
            $response = $this->request->curl->get("/{$this->entity}?skippages=0&pagesize=1");

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
     */
    public function get($filters = [])
    {
        $urlFilters = '';

        if (count($filters) > 0) {
            $urlFilters .= '?filter=';

            $i = 1;
            foreach ($filters as $filter) {
                $urlFilters .= $filter[0].$this->switchComparison($filter[1]).$this->escapeFilter($filter[2]); // todo fix arrays aswell ([1,2,3,...] string)

                if (count($filters) > $i) {
                    $urlFilters .= '$and:'; // todo allow $or: also
                }

                $i++;
            }
        }

        return $this->request->handleWithExceptions(function () use ($urlFilters) {
            $response = $this->request->curl->get("/{$this->entity}{$urlFilters}");

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
     */
    public function getByPage($page = 0, $pageSize = 500, $filters = [])
    {
        $items = collect([]);

        $urlFilters = '';

        if (count($filters) > 0) {
            $urlFilters .= '&filter=';

            $i = 1;
            foreach ($filters as $filter) {
                $urlFilters .= $filter[0].$this->switchComparison($filter[1]).$this->escapeFilter($filter[2]); // todo fix arrays aswell ([1,2,3,...] string)

                if (count($filters) > $i) {
                    $urlFilters .= '$and:'; // todo allow $or: also
                }

                $i++;
            }
        }

        return $this->request->handleWithExceptions(function () use ($pageSize, &$page, &$items, $urlFilters) {
            $response = $this->request->curl->get("/{$this->entity}?skippages={$page}&pagesize={$pageSize}{$urlFilters}");

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
     *
     * @return \Illuminate\Support\Collection|Model[]
     */
    public function all($filters = [], $pageSize = 500)
    {
        $page = 0;
        $pagesize = $pageSize;
        $hasMore = true;
        $items = collect([]);

        $urlFilters = '';

        if (count($filters) > 0) {
            $urlFilters .= '&filter=';

            $i = 1;
            foreach ($filters as $filter) {
                $urlFilters .= $filter[0].$this->switchComparison($filter[1]).$this->escapeFilter($filter[2]); // todo fix arrays aswell ([1,2,3,...] string)

                if (count($filters) > $i) {
                    $urlFilters .= '$and:'; // todo allow $or: also
                }

                $i++;
            }
        }

        return $this->request->handleWithExceptions(function () use (&$hasMore, $pagesize, &$page, &$items, $urlFilters) {
            while ($hasMore) {
                $response = $this->request->curl->get("/{$this->entity}?skippages={$page}&pagesize={$pagesize}{$urlFilters}");

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

    public function create($data)
    {
        return $this->request->handleWithExceptions(function () use ($data) {
            $response = $this->request->curl->post("/{$this->entity}", [
                'json' => $data,
            ]);

            $responseData = json_decode($response->getBody()->getContents());

            return new $this->model($this->request, $responseData);
        });
    }

    private function escapeFilter($variable)
    {
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
            $variable = str_replace($escapedString, '$'.$escapedString, $variable);
        }

        foreach ($urlencodedStrings as $urlencodedString) {
            $variable = str_replace($urlencodedString, urlencode($urlencodedString), $variable);
        }

        return $variable;
    }

    private function switchComparison($comparison)
    {
        switch ($comparison) {
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
