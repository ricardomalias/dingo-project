<?php

namespace App\feature\customer\repository;


use App\feature\customer\model\CustomerAddress;
use Core\Repository\BaseRepository;

class CustomerAddressRepository extends BaseRepository
{
    protected $model = CustomerAddress::class;

    public $pagination = false;
}