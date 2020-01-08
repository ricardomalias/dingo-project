<?php

namespace App\feature\CustomerList\repository;


use App\feature\CustomerList\model\CustomerListRelationship;
use App\Providers\Pagination;
use Core\Repository\BaseRepository;

class CustomerListRelationshipRepository extends BaseRepository
{
    protected $model = CustomerListRelationship::class;
}