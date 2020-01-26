<?php

namespace App\feature\CustomerList\controller;

use App\feature\CustomerList\form\CustomerListRequest;
use App\feature\CustomerList\service\CustomerListService;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\JsonResponse;

class CustomerListController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $customerListService;

    public function __construct()
    {
        $this->middleware('jwt.auth', []);
        $this->customerListService = new CustomerListService();
    }

    /**
     * Get customers
     *
     * @return JsonResponse
     */
    public function getCustomerLists(string $company_id)
    {
        $customer_list_service = $this->customerListService;
        $customer_list_service->company_id = $company_id;
        $customer_lists = $customer_list_service->getCustomerLists();

        return response()->api($customer_lists);
    }

    /**
     * Get customer
     *
     * @param string $customer_id
     * @return JsonResponse
     */
    public function getCustomerList(string $company_id, string $customer_list_id)
    {
        $customer_list_service = $this->customerListService;
        $customer_list = $customer_list_service->getCustomerList($customer_list_id);

        return response()->json($customer_list);
    }

    /**
     * Save customer list
     *
     * @param CustomerListRequest $request
     * @return JsonResponse
     */
    public function saveCustomerList(CustomerListRequest $request, $company_id)
    {
        $params = $request->only(['name']);
        $file = $request->file(['file']);
        if($file->getClientOriginalExtension() != 'csv') {
            return response()->json(['error' => 'Incorrect file formart'], 409);
        }

        $customer_list_service = $this->customerListService;
        $customer_list_service->company_id = $company_id;
        $customer_list_id = $customer_list_service->saveCustomerList($file, $params);

        return response()->json([
            'customer_list_id' => $customer_list_id
        ], 200);
    }

    // /**
    //  * Edit customer
    //  *
    //  * @param CustomerEditRequest $request
    //  * @return JsonResponse
    //  */
    // public function editCustomer(CustomerEditRequest $request)
    // {
    //     $params = $request->only(['name', 'documents', 'addresses']);
    //     $params = array_merge($params, ['customer_id' => $request->customer_id]);

    //     $customer_service = $this->customerService;
    //     $customer_service->customer_id = $request->customer_id;
    //     $customer = $customer_service->editCustomer($params);

    //     return response()->json($customer);
    // }

    // /**
    //  * Delete customer
    //  *
    //  * @param string $customer_id
    //  * @return JsonResponse
    //  */
    // public function deleteCustomer(string $customer_id)
    // {
    //     $customer_service = $this->customerService;
    //     $customer_service->deleteCustomer($customer_id);

    //     return response()->noContent();
    // }
}
