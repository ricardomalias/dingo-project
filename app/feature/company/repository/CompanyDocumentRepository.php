<?php

namespace App\feature\company\repository;

use App\feature\company\model\CompanyDocument;
use Core\Repository\BaseRepository;

class CompanyDocumentRepository extends BaseRepository
{
    protected $model = CompanyDocument::class;
}