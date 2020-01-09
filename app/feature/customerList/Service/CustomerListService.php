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

    public function getCustomerList(string $customer_list_id) {
        $customer_list_repository = $this->customerListRepository;
        $data = [
            'customer_list_id' => $customer_list_id
        ];

        return $customer_list_repository->getCustomerList($data);
    }

    public function getCustomerLists() {
        $customer_list_repository = $this->customerListRepository;
        $data = [
            'company_id' => $this->company_id,
        ];

        return $customer_list_repository->get($data);
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
                            'country' => 'Brasil',
                        ]
                    ]
                ]);
    
                $customer_list_relationship_repository->save([
                    'customer_list_id' => $customer_list_id,
                    'customer_id' => $customer_id,
                ]);

                if(!empty($line[7]) && !empty($line[8])) {
                    $discounts = null;
                    if(!empty($line[9]) && !empty($line[10]) && !empty($line[11])) {
                        $discounts = [
                            "type" => strtoupper($line[9]),
                            "value" => (float)$line[10],
                            "due_date" => $line[11],
                        ];
                    }

                    $debt_service->saveDebt([
                        'customer_id' => $customer_id,
                        'amount' => $line[7],
                        'parcel_quantity' => $line[8],
                        'discounts' => [$discounts],
                    ]);
                }
            }
        });

        return $customer_list_id;
    }

    public function deleteCustomerList(string $customer_list_id) {
        $customer_list_repository = $this->customerListRepository;

        return $customer_list_repository->delete([
            'customer_id' => $customer_id
        ]);
    }
}