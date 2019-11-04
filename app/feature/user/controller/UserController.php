<?php

namespace App\feature\user\controllers;

use App\feature\user\form\UserSaveRequest;
use App\feature\user\service\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
        $this->userService = new UserService();
    }

    /**
     * Get the authenticated User
     *
     * @return JsonResponse
     */
    /**
     * @SWG\Get(
     *   path="/user/me",
     *   summary="Get user logged",
     *   operationId="",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
//    public function me()
//    {
//        return response()->json(Auth::guard()->user());
//    }
    public function me()
    {
        $user = Auth::guard()->user();

        $user_service = $this->userService;
        $user_service->user_id = $user['user_id'];
        $user = $user_service->getUser();

        return response()->json($user);
    }

    public function getUser($id)
    {
        $user_service = $this->userService;
        $user_service->user_id = $id;
        $user = $user_service->getUser();

        return response()->json($user);
    }

    /**
     * @param UserSaveRequest $request
     * @return JsonResponse
     */
    public function saveUser(UserSaveRequest $request)
    {
        $params = $request->only(['name', 'email', 'password']);
        $params['company_id'] = $request->company_id;

        $user_service = $this->userService;
        $user_id = $user_service->saveUser($params);

        return response()->json([
            'user_id' => $user_id
        ]);
    }
}
