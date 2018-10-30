<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Journal extends Model
{
    protected $entity     = 'journals-experimental';
    protected $primaryKey = 'journalNumber';
    protected $fillable   = [
        'journalNumber',
        'entries',
        'name',
    ];

    public $journalNumber;
    public $name;

    public function entries()
    {

        return $this->request->handleWithExceptions( function () {
            $response =
                $this->request->curl->get( "/{$this->entity}/{$this->{$this->primaryKey}}/entries?pagesize=1000" );

            $responseData = json_decode( $response->getBody()->getContents() );

            $fetchedItems = $responseData->collection;

            $items = collect( [] );
            foreach ( $fetchedItems as $item ) {
                /** @var Model $model */
                $model = new Entry( $this->request, $item );

                $items->push( $model );
            }

            return $items;
        } );
    }
}
