<?php


namespace App\feature\customer\service;


use App\feature\customer\repository\CustomerDocumentRepository;

class CustomerDocumentService
{
    public $customer_id;

    private $customerDocumentRepository;

    public function __construct() {

        $this->customerDocumentRepository = new CustomerDocumentRepository();
    }

    public function getCustomerDocuments() {
        $customer_document_repository = $this->customerDocumentRepository;

        return $customer_document_repository->get([
            "customer_id" => $this->customer_id
        ]);
    }
    public function saveCustomerDocument(array $documents) {
        $customer_document_repository = $this->customerDocumentRepository;

        return collect($documents)->map(function ($document) use ($customer_document_repository) {
            $document['customer_id'] = $this->customer_id;
            $customer_document_repository->save($document);
        });
    }

    public function editCustomerDocument(array $documents) {
        $customer_document_repository = $this->customerDocumentRepository;

        $saved_documents = $this->getCustomerDocuments();

        collect($saved_documents)
            ->filter(function ($saved_document) use ($documents) {

                $usages = collect($documents)
                    ->filter(function ($document) use ($saved_document) {
                        return $saved_document['type'] == $document['type'] && $saved_document['value'] == $document['value'];
                    });
                return $usages->count() > 0;
            })
            ->map(function ($document) use ($customer_document_repository) {
                $customer_document_repository->delete($document);
            });

        return collect($documents)
            ->map(function ($document) use ($customer_document_repository) {
                $document['customer_id'] = $this->customer_id;
                $customer_document_repository->save($document);

                return $document;
            });
    }

    public function deleteCustomerDocuments(array $documents) {
        $customer_document_repository = $this->customerDocumentRepository;

        return collect($documents)
            ->map(function ($document) use ($customer_document_repository) {
                $document['customer_id'] = $this->customer_id;
                $customer_document_repository->delete($document);

                return $document;
            });
    }
}