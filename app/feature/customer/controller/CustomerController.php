<?php

namespace App\feature\customer\controller;

use App\Api\V1\Requests\CompanyEditRequest;
use App\Api\V1\Requests\CompanySaveRequest;
use App\feature\customer\service\CustomerService;
use App\Http\Controllers\Controller;
use Auth;

class CustomerController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $customerService;

    public function __construct()
    {
        $this->middleware('jwt.auth', []);
        $this->customerService = new CustomerService();
    }

    /**
     * Get companies
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomers()
    {
        $customer_service = $this->customerService;
        $customers = $customer_service->getCustomers();

        return response()->api($customers);
    }

    /**
     * Get company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomer($company_id)
    {
        $customer_service = $this->customerService;
        $curtomer = $customer_service->getCompany($company_id);

        return response()->json($curtomer);
    }

    /**
     * Save company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomer(CustomerSaveRequest $request)
    {
        $params = $request->only(['name', 'documents']);

        $customer_service = $this->customerService;
        $customer_id = $customer_service->saveCustomer($params);

        return response()->json([
            'customer_id' => $customer_id
        ]);
    }

    /**
     * Edit company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCustomer(CustomerEditRequest $request)
    {
        $params = $request->only(['name', 'documents']);
        $params = array_merge($params, ['customer_id' => $request->customer_id]);

        $customer_service = $this->customerService;
        $company = $customer_service->editCustomer($params);

        return response()->json($company);
    }

    /**
     * Delete company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCustomer($customer_id)
    {

        $customer_service = $this->customerService;
        $customer_service->deleteCustomer($customer_id);

        return response()->noContent();
    }
}
