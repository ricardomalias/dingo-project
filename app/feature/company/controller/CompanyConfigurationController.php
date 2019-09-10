<?php

namespace App\feature\company\controller;

use App\Http\Controllers\Controller;
use App\feature\company\service\CompanyConfigurationService;
use App\feature\company\repository\CompanyConfigurationRequest;
use Illuminate\Support\Facades\Auth;

class CompanyConfigurationController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $companyConfigurationService;

    public function __construct()
    {
        $this->middleware('jwt.auth', []);
        $this->companyConfigurationService = new CompanyConfigurationService();
    }

    /**
     * Get company configurations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyConfigurations($company_id)
    {
        $company_configuration_service = $this->companyConfigurationService;
        $company_configuration_service->company_id = $company_id;
        $configurations = $company_configuration_service->getCompanyConfigurations();

        return response()->api($configurations);
    }

    /**
     * Edit company configurations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCompanyConfiguration(CompanyConfigurationRequest $request)
    {
        $params = $request->only(['configurations']);

        $company_configuration_service = $this->companyConfigurationService;
        $company_configuration_service->company_id = $request->company_id;

        $configuration = $company_configuration_service->editCompanyConfiguration($params['configurations']);

        return response()->json($configuration);
    }
}