<?php


namespace App\feature\company\service;


use App\feature\company\repository\CompanyDocumentRepository;

class CompanyDocumentService
{
    public $company_id;

    private $companyDocumentRepository;

    public function __construct() {

        $this->companyDocumentRepository = new CompanyDocumentRepository();
    }

    public function getCompanyDocument() {
        $company_document_repository = $this->companyDocumentRepository;

        return $company_document_repository->get([
            "company_id" => $this->company_id
        ]);
    }

    public function saveCompanyDocument(array $documents) {
        $company_document_repository = $this->companyDocumentRepository;

        collect($documents)->map(function ($document) use ($company_document_repository) {
            $document['company_id'] = $this->company_id;
            $company_document_repository->save($document);
        });
    }
}