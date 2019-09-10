<?php

namespace App\feature\company\controller;

use App\Http\Controllers\Controller;
use App\feature\company\service\CompanyConfigurationService;
use App\feature\company\repository\CompanyConfigurationRequest;
use Auth;

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
    public function getCompanyConfigurations()
    {
        $company_configuration_service = $this->companyConfigurationService;
        $configurations = $company_configuration_service->getCompanyConfigurations();

        return response()->api($configurations);
    }

    /**
     * Edit company configurations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCompany(CompanyConfigurationRequest $request)
    {
        $params = $request->only(['configurations']);
        $params = array_merge($params, ['company_id' => $request->company_id]);

        $company_service = $this->companyConfigurationService;
        $company = $company_service->editCompanyConfiguration($params);

        return response()->json($company);
    }
}