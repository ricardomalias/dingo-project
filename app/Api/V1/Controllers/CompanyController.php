<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\CompanyEditRequest;
use App\Api\V1\Requests\CompanySaveRequest;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\CompanyRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Feature\Service\Company\CompanyService;
use Auth;

class CompanyController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private $companyService;

    public function __construct()
    {
        $this->middleware('jwt.auth', []);
        $this->companyService = new CompanyService();
    }

    /**
     * Get companies
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanies()
    {
        $company_service = $this->companyService;
        $companies = $company_service->getCompanies();

        return response()->api($companies);
    }

    /**
     * Get company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompany($company_id)
    {
        $company_service = $this->companyService;
        $companies = $company_service->getCompany($company_id);

        return response()->json($companies);
    }

    /**
     * Save company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCompany(CompanySaveRequest $request)
    {
        $params = $request->only(['name', 'documents']);

        $company_service = $this->companyService;
        $company_id = $company_service->saveCompany($params);

        return response()->json([
            'company_id' => $company_id
        ]);
    }

    /**
     * Edit company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCompany(CompanyEditRequest $request)
    {
        $params = $request->only(['name', 'document']);
        $params = array_merge($params, ['company_id' => $request->company_id]);

        $company_service = $this->companyService;
        $company = $company_service->editCompany($params);

        return response()->json($company);
    }

    /**
     * Delete company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCompany($company_id)
    {

        $company_service = $this->companyService;
        $company_service->deleteCompany($company_id);

        return response()->noContent();
    }
}
