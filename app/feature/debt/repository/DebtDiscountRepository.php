<?php


namespace App\feature\debt\repository;


use App\feature\debt\model\DebtDiscount;
use Core\Repository\BaseRepository;

class DebtDiscountRepository extends BaseRepository
{
    protected $model = DebtDiscount::class;
}