<?php

namespace App\feature\customer\repository;


use App\feature\customer\model\Customer;
use App\Providers\Pagination;
use Core\Repository\BaseRepository;

class CustomerRepository extends BaseRepository
{
    protected $model = Customer::class;

    public function getCustomers() {
        $model = new $this->model();

        $model = $model->with("addresses")
            ->with("documents")
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
}