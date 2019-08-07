<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
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
        echo 'getCompanies';
        // return response()->json(Auth::guard()->user());
    }

    /**
     * Get company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompany()
    {
        echo 'getCompany';
        $company_service = $this->companyService;
        $company_service->getCompany();
        // return response()->json(Auth::guard()->user());
    }

    /**
     * Save company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCompany()
    {
        echo 'save company';
        // return response()->json(Auth::guard()->user());
    }

    /**
     * Edit company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editCompany()
    {
        echo 'edit company';
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
