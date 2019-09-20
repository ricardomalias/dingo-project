<?php

namespace App\Feature\Service\Company;

use App\feature\company\service\CompanyDocumentService;
use App\Feature\Repository\CompanyRepository;
use Illuminate\Support\ServiceProvider;

class CompanyService extends ServiceProvider {

    private $companyDocumentService;

    private $companyRepository;

    public function __construct() {

        $this->companyRepository = new CompanyRepository();
        $this->companyDocumentService = new CompanyDocumentService();
    }

    public function getCompanies() {
        $company_document_service = $this->companyDocumentService;

        $company_repository = $this->companyRepository;

        $companies = $company_repository->get();

        return collect($companies)
            ->map(function ($company) use ($company_document_service) {
                $company_document_service->company_id = $company['company_id'];

                $company['documents'] = $company_document_service->getCompanyDocuments();
                return $company;
            });
    }

    public function getCompany($company_id) {
        $company_document_service = $this->companyDocumentService;
        $company_document_service->company_id = $company_id;

        $company_repository = $this->companyRepository;

        $company = $company_repository->first([
            'company_id' => $company_id
        ]);

        $company['documents'] = $company_document_service->getCompanyDocuments();

        return $company;
    }

    public function saveCompany($data) {
        $company_document_service = $this->companyDocumentService;

        $company_repository = $this->companyRepository;

        $company_id = $company_repository->saveCompany($data);

        $company_document_service->company_id = $company_id;
        $company_document_service->saveCompanyDocument($data['documents']);

        return $company_id;
    }

    public function editCompany($data) {
        $company_document_service = $this->companyDocumentService;
        $company_document_service->company_id = $data['company_id'];

        $company_repository = $this->companyRepository;

        $company = $company_repository->editCompany($data);
        $company_document_service->editCompanyDocument($data['documents']);

        return $company;
    }

    public function deleteCompany(string $company_id) {
        $company_repository = $this->companyRepository;
        $company_document_service = $this->companyDocumentService;
        $company_document_service->company_id = $company_id;

        $documents = $company_document_service->getCompanyDocuments();

        if(!empty($documents)) {
            $company_document_service->deleteCompanyDocuments($documents);
        }

        return $company_repository->deleteCompany($company_id);
    }
}
