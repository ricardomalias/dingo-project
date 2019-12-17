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

    public function __construct()
    {
        $this->debtService = new DebtService();
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
}
