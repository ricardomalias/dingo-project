<?php

namespace App\feature\CustomerList\service;


use App\feature\CustomerList\repository\CustomerListRepository;
use App\feature\CustomerList\repository\CustomerListRelationshipRepository;
use App\feature\customer\service\CustomerService;
use App\feature\debt\service\DebtService;
use App\Providers\CSVReader;

class CustomerListService
{
    public $company_id;

    private $customerListRepository;
    private $customerListRelationshipRepository;

    private $customerService;
    private $debtService;

    public function __construct() {
        $this->customerListRepository = new CustomerListRepository();
        $this->customerListRelationshipRepository = new CustomerListRelationshipRepository();

        $this->customerService = new CustomerService();
        $this->debtService = new DebtService();
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

    public function saveCustomerList($file, array $params) {
        $customer_list_repository = $this->customerListRepository;
        $customer_list_relationship_repository = $this->customerListRelationshipRepository;

        $customer_service = $this->customerService;
        $customer_service->company_id = $this->company_id;

        $debt_service = $this->debtService;

        // $params = [
            // 'company_id' => $this->company_id,
            // 'name' => $file->getClientOriginalName()
        // ];
        $params['company_id'] = $this->company_id;
        $customer_list_id = $customer_list_repository->save($params);

        $data = CSVReader::read($file);
        unset($data[0]);
        collect($data)->map(function($line) use ($customer_list_id,
                                                $customer_service,
                                                $debt_service,
                                                $customer_list_relationship_repository) {

            if(!empty($line) && count($line) >= 8) {
                $customer_id = $customer_service->saveCustomer([
                    'company_id' => $this->company_id,
                    'name' => $line[0],
                    'documents' => [
                        [
                            'type' => 'CPF',
                            'value' => $line[1],
                        ]
                    ],
                    'addresses' => [
                        [
                            'zip_code' => $line[2],
                            'address' => $line[3],
                            'number' => $line[4],
                            'city' => $line[5],
                            'state' => $line[6],
                            'country' => $line[7],
                        ]
                    ]
                ]);
    
                $customer_list_relationship_repository->save([
                    'customer_list_id' => $customer_list_id,
                    'customer_id' => $customer_id,
                ]);

                if(!empty($line[8]) && !empty($line[9])) {
                    $discounts = null;
                    if(!empty($line[10]) && !empty($line[11]) && !empty($line[12])) {
                        $discounts = [
                            "type" => strtoupper($line[10]),
                            "value" => (float)$line[11],
                            "due_date" => $line[12],
                        ];
                    }

                    $debt_service->saveDebt([
                        'customer_id' => $customer_id,
                        'amount' => $line[8],
                        'parcel_quantity' => $line[9],
                        'discounts' => [$discounts],
                    ]);
                }
            }
        });

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