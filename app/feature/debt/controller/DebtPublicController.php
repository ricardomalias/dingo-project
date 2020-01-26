<?php


namespace App\feature\debt\controller;


use App\feature\company\service\CompanyConfigurationService;
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

    private $companyConfigurationService;

    public function __construct()
    {
        $this->debtService = new DebtService();
        $this->customerService = new CustomerService();
        $this->companyConfigurationService = new CompanyConfigurationService();
    }

    /**
     * Get debt
     *
     * @param $debt_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDebt($debt_id)
    {
        $customer = [];
        $company_configurations = [];

        $debt_service = $this->debtService;
        $debt_service->debt_id = $debt_id;

        $debt = $debt_service->getDebt();

        if(!empty($debt)) {
            $customer_service = $this->customerService;
            $company_configuration_service = $this->companyConfigurationService;

            $customer = $customer_service->getCustomer($debt['customer_id']);
            $company_configuration_service->company_id = $customer['company_id'];
            $company_configurations = $company_configuration_service->getCompanyConfigurations();
        }

        return response()->json([
            'debt' => $debt,
            'customer' => $customer,
            'configurations' => $company_configurations
        ]);
    }

    public function saveDebtNegotiation()
    {


        return $this->response()->json([
           'hello'
        ]);
    }
}
