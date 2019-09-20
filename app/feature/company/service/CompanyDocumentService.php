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

    public function getCompanyDocuments() {
        $company_document_repository = $this->companyDocumentRepository;

        return $company_document_repository->get([
            "company_id" => $this->company_id
        ]);
    }

    public function saveCompanyDocument(array $documents) {
        $company_document_repository = $this->companyDocumentRepository;

        return collect($documents)->map(function ($document) use ($company_document_repository) {
            $document['company_id'] = $this->company_id;
            $company_document_repository->save($document);
        });
    }

    public function editCompanyDocument(array $documents) {
        $company_document_repository = $this->companyDocumentRepository;

        $saved_documents = $this->getCompanyDocuments();

        collect($saved_documents)
            ->filter(function ($saved_document) use ($documents) {

                $usages = collect($documents)
                    ->filter(function ($document) use ($saved_document) {
                        return $saved_document['type'] == $document['type'] && $saved_document['value'] == $document['value'];
                    });
                return $usages->count() > 0;
            })
            ->map(function ($document) use ($company_document_repository) {
                $company_document_repository->delete($document);
            });

        return collect($documents)
            ->map(function ($document) use ($company_document_repository) {
                $document['company_id'] = $this->company_id;
                $company_document_repository->save($document);

                return $document;
            });
    }

    public function deleteCompanyDocuments(array $documents) {
        $company_document_repository = $this->companyDocumentRepository;

        return collect($documents)
            ->map(function ($document) use ($company_document_repository) {
                $document['company_id'] = $this->company_id;
                $company_document_repository->delete($document);

                return $document;
            });
    }
}