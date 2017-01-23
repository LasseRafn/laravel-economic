<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Employee extends Model
{
	protected $entity     = 'employees';
	protected $primaryKey = 'employeeNumber';
	protected $fillable   = [
		'barred',
		'bookedInvoices',
		'customers',
		'draftInvoices',
		'email',
		'employeeGroup',
		'employeeNumber',
		'name',
		'phone',
		'self',
	];

	public $barred;
	public $bookedInvoices;
	public $customers;
	public $draftInvoices;
	public $email;
	public $employeeGroup;
	public $employeeNumber;
	public $name;
	public $phone;
	public $self;
}