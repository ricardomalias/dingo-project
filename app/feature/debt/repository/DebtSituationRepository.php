<?php


namespace App\feature\debt\repository;


use App\feature\debt\model\DebtSituation;
use Core\Repository\BaseRepository;

class DebtSituationRepository extends BaseRepository
{
    protected $model = DebtSituation::class;
}