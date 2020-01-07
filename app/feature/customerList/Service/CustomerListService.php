<?php

namespace App\feature\CustomerList\service;


use App\feature\CustomerList\repository\CustomerListRepository;
use App\feature\CustomerList\repository\CustomerListRelationshipRepository;
use App\Providers\CSVReader;

class CustomerListService
{
    public $company_id;

    private $customerListRepository;
    private $customerListRelationshipRepository;

    public function __construct() {
        $this->customerListRepository = new CustomerListRepository();
        $this->customerListRelationshipRepository = new CustomerListRelationshipRepository();
    }

    public function getCustomer(string $customer_id) {
        $customer_repository = $this->customerRepository;
        $data = [
            'customer_id' => $customer_id
        ];

        return $customer_repository->getCustomer($data);
    }

    public function getCustomers(string $query = null) {
        $customer_repository = $this->customerRepository;
        $data = [
            'company_id' => $this->company_id,
            'query' => $query
        ];

        return $customer_repository->getCustomers($data);
    }

    public function saveCustomerList($file) {
        $customer_list_repository = $this->customerListRepository;

        $data = CSVReader::read($file);
        return $data;

        // $customer_list_id = $customer_list_repository->save($data);

        return $customer_list_id;
    }

    public function editCustomer(array $data) {
        $customer_repository = $this->customerRepository;

        $customer_address_service = $this->customerAddressService;
        $customer_address_service->customer_id = $data['customer_id'];
        $customer_document_service = $this->customerDocumentService;
        $customer_document_service->customer_id = $data['customer_id'];

        $customer_repository->update(
            [
                'name' => $data['name'],
            ],
            [
                'customer_id' => $this->customer_id
            ]
        );

        $customer_address_service->editCustomerAddress($data['addresses']);
        $customer_document_service->editCustomerDocument($data['documents']);

        return $customer_repository->first([
            'customer_id' => $this->customer_id
        ]);
    }

    public function deleteCustomer(string $customer_id) {
        $customer_repository = $this->customerRepository;

        $customer_address_service = $this->customerAddressService;
        $customer_address_service->customer_id = $customer_id;
        $customer_document_service = $this->customerDocumentService;
        $customer_document_service->customer_id = $customer_id;

        $addresses = $customer_address_service->getCustomerAddresses();
        $documents = $customer_document_service->getCustomerDocuments();

        if(!empty($addresses)) {
            $customer_address_service->deleteCustomerAddresses($addresses);
        }

        if(!empty($documents)) {
            $customer_document_service->deleteCustomerDocuments($documents);
        }

        return $customer_repository->delete([
            'customer_id' => $customer_id
        ]);
    }
}