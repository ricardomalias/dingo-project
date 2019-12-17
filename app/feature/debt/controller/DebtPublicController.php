<?php


namespace App\feature\debt\controller;


use App\feature\customer\service\CustomerService;
use App\feature\debt\form\DebtEditRequest;
use App\feature\debt\form\DebtSaveRequest;
use App\feature\debt\service\DebtService;
use App\Providers\BaseControllerProvider;
use Illuminate\Support\Facades\Auth;

class DebtPublicController extends BaseControllerProvider
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $debtService;

    private $customerService;

    public function __construct()
    {
        $this->debtService = new DebtService();
        $this->customerService = new CustomerService();
    }

    /**
     * Get debt
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDebt($debt_id)
    {
        $customer = [];

        $debt_service = $this->debtService;
        $debt_service->debt_id = $debt_id;

        $debt = $debt_service->getDebt();

        if(!empty($debt)) {
            $customer_service = $this->customerService;

            $customer = $customer_service->getCustomer($debt['customer_id']);
        }

        return response()->json([
            'debt' => $debt,
            'customer' => $customer
        ]);
    }
}
