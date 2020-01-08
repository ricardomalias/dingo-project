<?php


namespace App\feature\customer\service;


use App\feature\customer\repository\CustomerAddressRepository;

class CustomerAddressService
{
    public $customer_id;

    private $customerAddressRepository;

    public function __construct() {
        $this->customerAddressRepository = new CustomerAddressRepository();
    }

    public function getCustomerAddresses() {
        $customer_address_repository = $this->customerAddressRepository;

        return $customer_address_repository->get([
            "customer_id" => $this->customer_id
        ]);
    }
    public function saveCustomerAddress(array $addresses) {
        $customer_address_repository = $this->customerAddressRepository;

        return collect($addresses)->map(function ($address) use ($customer_address_repository) {
            $address['customer_id'] = $this->customer_id;
            $customer_address_repository->save($address);
        });
    }

    public function editCustomerAddress(array $addresses) {
        $customer_address_repository = $this->customerAddressRepository;

        $saved_addresses = $this->getCustomerAddresses();

        collect($saved_addresses)
            ->map(function ($address) use ($customer_address_repository) {
                $customer_address_repository->delete($address);
            });

        return collect($addresses)
            ->map(function ($address) use ($customer_address_repository) {
                $address['customer_id'] = $this->customer_id;
                $customer_address_repository->save($address);

                return $address;
            });
    }

    public function deleteCustomerAddresses(array $addresses) {
        $customer_address_repository = $this->customerAddressRepository;

        return collect($addresses)
            ->map(function ($address) use ($customer_address_repository) {
                $address['customer_id'] = $this->customer_id;
                $customer_address_repository->delete($address);

                return $address;
            });
    }
}