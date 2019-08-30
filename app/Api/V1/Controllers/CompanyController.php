<?php

namespace App\Api\V1\Controllers;

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
        $companies = $company_service->getCompany();

        return response()->api($companies);
    }

    /**
     * Get company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompany()
    {
        $company_service = $this->companyService;
        $companies = $company_service->getCompany();

        return response()->api($companies);
    }

    /**
     * Save company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCompany(CompanyRequest $request)
    {
        $params = $request->only(['name']);

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
    public function editCompany(CompanyRequest $request)
    {
        $params = $request->only(['name', 'company_id']);

        $company_service = $this->companyService;
        $company_id = $company_service->editCompany($params);

//        return response()->json([
//            'company_id' => $company_id
//        ]);
        // return response()->json(Auth::guard()->user());
    }

    /**
     * Delete company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCompany()
    {
        echo 'delete company';
        // return response()->json(Auth::guard()->user());
    }
}
