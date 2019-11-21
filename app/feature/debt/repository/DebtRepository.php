<?php


namespace App\feature\debt\repository;


use App\feature\debt\model\Debt;
use App\Providers\Pagination;
use Core\Repository\BaseRepository;

class DebtRepository extends BaseRepository
{
    protected $model = Debt::class;

    public function getDebts(array $data) {
        $model = new $this->model();

        $model = $model->with("situation")
            ->where('customer_id', '=', $data['customer_id'])
            ->where('status', '=', 1)
            ->orderBy('created_at', 'asc');

        if($this->pagination === true)
        {
            $result = Pagination::make($model, $this->perPage);
        }
        else
        {
            $result = $model->get();
        }

        return $result;
    }

    public function getDebt(array $data) {
        $model = new $this->model();

        return $model->with("situation")
            ->where('debt_id', '=', $data['debt_id'])
            ->orderBy('created_at', 'asc')
            ->first();
    }
}