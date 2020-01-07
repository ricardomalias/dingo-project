<?php

namespace App\feature\CustomerList\repository;


use App\feature\customer\model\Customer;
use App\Providers\Pagination;
use Core\Repository\BaseRepository;

class CustomerListRelationshipRepository extends BaseRepository
{
    protected $model = CustomerListRelationship::class;
}