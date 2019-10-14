<?php

namespace App\feature\customer\controller;

use App\Api\V1\Requests\CompanyEditRequest;
use App\Api\V1\Requests\CompanySaveRequest;
use App\feature\customer\form\CustomerEditRequest;
use App\feature\customer\form\CustomerSaveRequest;
use App\feature\customer\service\CustomerService;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function getCustomers($company_id)
    {
        $customer_service = $this->customerService;
        $customer_service->company_id = $company_id;
        $customers = $customer_service->getCustomers();

        return response()->api($customers);
    }

    /**
     * Get company
     *
     * @param string $company_id
     * @return JsonResponse
     */
    public function getCustomer(string $company_id)
    {
        $customer_service = $this->customerService;
        $curtomer = $customer_service->getCompany($company_id);

        return response()->json($curtomer);
    }

    /**
     * Save company
     *
     * @param CustomerSaveRequest $request
     * @return JsonResponse
     */
    public function saveCustomer(CustomerSaveRequest $request)
    {
        $params = $request->only(['company_id', 'name', 'documents', 'addresses']);

        $customer_service = $this->customerService;
        $customer_id = $customer_service->saveCustomer($params);

        return response()->json([
            'customer_id' => $customer_id
        ]);
    }

    /**
     * Edit company
     *
     * @param CustomerEditRequest $request
     * @return JsonResponse
     */
    public function editCustomer(CustomerEditRequest $request)
    {
        $params = $request->only(['name', 'documents', 'addresses']);
        $params = array_merge($params, ['customer_id' => $request->customer_id]);

        $customer_service = $this->customerService;
        $customer_service->customer_id = $request->customer_id;
        $customer = $customer_service->editCustomer($params);

        return response()->json($customer);
    }

    /**
     * Delete company
     *
     * @param string $customer_id
     * @return JsonResponse
     */
    public function deleteCustomer(string $customer_id)
    {
        $customer_service = $this->customerService;
        $customer_service->deleteCustomer($customer_id);

        return response()->noContent();
    }
}
