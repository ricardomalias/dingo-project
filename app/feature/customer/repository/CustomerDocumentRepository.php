<?php

namespace App\feature\customer\repository;


use App\feature\customer\model\CustomerDocument;
use Core\Repository\BaseRepository;

class CustomerDocumentRepository extends BaseRepository
{
    protected $model = CustomerDocument::class;

    public $pagination = false;
}