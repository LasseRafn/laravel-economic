<?php namespace LasseRafn\Economic\Builders;


use LasseRafn\Economic\Models\Entry;

class EntryBuilder extends Builder
{
	protected $entity = 'entries';
	protected $model = Entry::class;
}