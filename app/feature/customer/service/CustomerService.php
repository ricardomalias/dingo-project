<?php

namespace App\feature\customer\service;


use App\feature\customer\repository\CustomerRepository;

class CustomerService
{
    public $customer_id;
    public $company_id;

    private $customerRepository;

    private $customerAddressService;
    private $customerDocumentService;

    public function __construct() {

        $this->customerRepository = new CustomerRepository();

        $this->customerAddressService = new CustomerAddressService();
        $this->customerDocumentService = new CustomerDocumentService();
    }

    public function getCustomer(string $customer_id) {
        $customer_repository = $this->customerRepository;
        $data = [
            'customer_id' => $customer_id
        ];

        return $customer_repository->getCustomer($data);
    }

    public function getCustomers() {
        $customer_repository = $this->customerRepository;
        $data = [
            'company_id' => $this->company_id
        ];

        return $customer_repository->getCustomers($data);
    }

    public function saveCustomer(array $data) {
        $customer_repository = $this->customerRepository;

        $customer_address_service = $this->customerAddressService;
        $customer_document_service = $this->customerDocumentService;

        $customer_id = $customer_repository->save($data);

        $customer_address_service->customer_id = $customer_id;
        $customer_address_service->saveCustomerAddress($data['addresses']);

        $customer_document_service->customer_id = $customer_id;
        $customer_document_service->saveCustomerDocument($data['documents']);

        return $customer_id;
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
            $customer_address_service->deleteCustomerAddresses($documents);
        }

        if(!empty($documents)) {
            $customer_document_service->deleteCustomerDocuments($documents);
        }

        return $customer_repository->delete([
            'customer_id' => $customer_id
        ]);
    }
}