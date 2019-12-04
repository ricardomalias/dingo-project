<?php


namespace App\feature\debt\repository;


use App\feature\customer\model\Customer;
use App\feature\debt\model\Debt;
use App\Providers\Pagination;
use Core\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;

class DebtRepository extends BaseRepository
{
    protected $model = Debt::class;

    public function getDebts(array $data) {
        $model = new $this->model();

        $model = $model->with("situation")
            ->with("discount")
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

        return $model->with("discounts")
            ->with("discounts")
            ->where('debt_id', '=', $data['debt_id'])
            ->orderBy('created_at', 'asc')
            ->first();
    }

    /**
     * Postgres do not cast appropriately joins, read more below:
     * https://stackoverflow.com/questions/51435772/laravel-postgresql-join-error-operator-does-not-exist
     */
    public function getCompanyDebts(array $data) {
        $model = new $this->model();

        $model = $model
            ->select("debt.debt_id", "debt.customer_id", "debt.amount", "debt.parcel_quantity", "debt.created_at", "debt.updated_at", "debt.status", "customer.name")
            ->join('customer', function ($join) {
                $join->on(DB::raw("debt.customer_id::VARCHAR"), '=', DB::raw("customer.customer_id::VARCHAR"));
            })
            ->where("customer.company_id", "=", $data['company_id'])
            ->where('debt.status', '=', 1)
            ->orderBy('debt.created_at', 'asc');

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
}