<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class SingleBuilder
{
    private $request;
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
    {//todo test
        $response = $this->request->curl->get("/{$this->entity}/{$id}");

        // todo check for errors and such

        $responseData = json_decode($response->getBody()->getContents());

        return new $this->model($this->request, $responseData);
    }

    /**
     * @param array $filters
     *
     * @return \Illuminate\Support\Collection|Model[]
     */
    public function get()
    {
        $response = $this->request->curl->get("/{$this->entity}");

        // todo check for errors and such

        $responseData = json_decode($response->getBody()->getContents());

        return $responseData;
    }
}
