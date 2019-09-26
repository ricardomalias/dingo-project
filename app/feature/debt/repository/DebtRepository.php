<?php


namespace App\feature\debt\repository;


use App\feature\debt\model\Debt;
use Core\Repository\BaseRepository;

class DebtRepository extends BaseRepository
{
    protected $model = Debt::class;
}