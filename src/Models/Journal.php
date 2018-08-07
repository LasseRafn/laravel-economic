<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Journal extends Model
{
    protected $entity = 'journals-experimental';
    protected $primaryKey = 'journalNumber';

    public $journalNumber;
    public $entries;
    public $name;
}
