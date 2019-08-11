<?php

namespace App\Feature\Service\Company;

use App\Company as Company;

class CompanyService {

    public function getCompany() {
        // $companies = Company::orderBy('created_at', 'desc')->paginate(20);
        $companies = Company::take(20)->get();

        return $companies;
    }

    public function saveCompany($data) {

        $company_model = new Company();
        $company_model->name = $data['name'];
        $company_model->status = 1;

        if($company_model->save())
        {
            return $company_model->company_id;
        }
    }
}
