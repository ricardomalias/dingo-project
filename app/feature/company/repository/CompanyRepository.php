<?php

namespace App\Feature\Repository;

use App\feature\Company as Company;
use Core\Repository\BaseRepository;
use Illuminate\Support\Str;

class CompanyRepository extends BaseRepository {

    protected $model = Company::class;

    public function saveCompany(array $data) {
        $company_model = new $this->model();
        $company_model->company_id = (String) Str::uuid();
        $company_model->name = $data['name'];
        $company_model->status = 1;

        if($company_model->save())
        {
            return $company_model->company_id;
        }

        return null;
    }

    public function editCompany(array $data) {
        $company_model = new $this->model();
        $company_model = $company_model->where(array(
            'company_id' => $data['company_id']
        ));

        if($company_model->count()) {
            $data_edit = array();

            $data_edit['name'] = $data['name'];

            if($company_model->update($data_edit))
            {
                return $company_model->first();
            }
        }

        return null;
    }

    public function deleteCompany(string $company_id) {
        $company_model = new $this->model();

        $company_model = $company_model->where(array(
            'company_id' => $company_id
        ));

        if($company_model->count()) {
            return $company_model->delete();
        }
    }
}



