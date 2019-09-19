<?php


namespace App\feature\customer\service;


use App\feature\customer\repository\CustomerRepository;

class CustomerService
{
    private $customerRepository;

    public function __construct() {

        $this->customerRepository = new CustomerRepository();
    }

    public function getCustomers() {

    }
}