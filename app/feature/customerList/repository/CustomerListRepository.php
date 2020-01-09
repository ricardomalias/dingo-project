<?php

namespace App\feature\CustomerList\repository;


use App\feature\CustomerList\model\CustomerList;
use App\Providers\Pagination;
use Core\Repository\BaseRepository;

class CustomerListRepository extends BaseRepository
{
    protected $model = CustomerList::class;

    public function getCustomerList(array $data) {
        $model = new $this->model();

        return $model
            ->with("customers")
            ->where('customer_list_id', '=', $data['customer_list_id'])
            ->orderBy('created_at', 'asc')
            ->first();
    }
}