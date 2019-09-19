<?php


namespace App\feature\customer\repository;


use App\feature\customer\model\Customer;
use Core\Repository\BaseRepository;

class CustomerRepository extends BaseRepository
{
    protected $model = Customer::class;
}