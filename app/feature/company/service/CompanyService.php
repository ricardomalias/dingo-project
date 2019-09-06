<?php

namespace App\Feature\Service\Company;

use App\feature\Company as Company;
use App\Feature\Repository\CompanyRepository;

class CompanyService {

    private $companyRepository;

    public function __construct() {

        $this->companyRepository = new CompanyRepository();
    }

    public function getCompanies() {
        $company_repository = $this->companyRepository;

        return $company_repository->get();
    }

    public function getCompany($uid_company) {
        $company_repository = $this->companyRepository;

        return $company_repository->first([
            'company_id' => $uid_company
        ]);
    }

    public function saveCompany($data) {
        $company_repository = $this->companyRepository;

        $company_id = $company_repository->saveCompany($data);

        return $company_id;
    }

    public function editCompany($data) {
        $company_repository = $this->companyRepository;

        $company = $company_repository->editCompany($data);

        return $company;
    }

    public function deleteCompany(string $company_id) {
        $company_repository = $this->companyRepository;

        $company = $company_repository->deleteCompany($company_id);

        return $company;
    }
}
