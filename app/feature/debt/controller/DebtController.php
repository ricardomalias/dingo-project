<?php


namespace App\feature\debt\controller;


use App\feature\customer\service\CustomerService;
use App\feature\debt\form\DebtEditRequest;
use App\feature\debt\form\DebtSaveRequest;
use App\feature\debt\service\DebtService;
use App\Providers\BaseControllerProvider;
use Illuminate\Support\Facades\Auth;

class DebtController extends BaseControllerProvider
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $debtService;

    public function __construct()
    {
        $this->middleware('jwt.auth', []);
        $this->debtService = new DebtService();
    }

    /**
     * Get debts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyDebts($company_id)
    {
        $customer_service = new CustomerService();
        $customer_service->company_id = $company_id;

        $debt_service = $this->debtService;
        $debt_service->setCustomerService($customer_service);
        $debts = $debt_service->getCompanyDebts($company_id);

        return response()->api($debts);
    }

    /**
     * Get customer debts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerDebts($customer_id)
    {
        $debt_service = $this->debtService;
        $debt_service->customer_id = $customer_id;
        $debts = $debt_service->getCustomerDebts();

        return response()->api($debts);
    }

    /**
     * Get debt
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDebt($debt_id)
    {
        $debt_service = $this->debtService;
        $debt_service->debt_id = $debt_id;
        $debt = $debt_service->getDebt();

        return response()->json($debt);
    }

    /**
     * Save debt
     *
     * @param DebtSaveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveDebt(DebtSaveRequest $request)
    {
        $params = $request->only([
            'customer_id',
            'amount',
            'parcel_quantity',
            'discounts'
        ]);

        $debt_service = $this->debtService;
        $debt_id = $debt_service->saveDebt($params);

        return response()->json([
            'debt_id' => $debt_id
        ]);
    }

    /**
     * Edit debt
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editDebt(DebtEditRequest $request)
    {
        $params = $request->only([
            'amount',
            'parcel_quantity',
            'situation',
            'discounts'
        ]);

        $debt_service = $this->debtService;
        $debt_service->debt_id = $request->debt_id;
        $debt = $debt_service->editDebt($params);

        return response()->json($debt);
    }

    /**
     * Delete debt
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteDebt($debt_id)
    {

        $debt_service = $this->debtService;
        $debt_service->debt_id = $debt_id;
        $debt_service->deleteDebt();

        return response()->noContent();
    }
}
