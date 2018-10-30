<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Builders\EntryBuilder;
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
        return new EntryBuilder( $this->request );
    }
}
