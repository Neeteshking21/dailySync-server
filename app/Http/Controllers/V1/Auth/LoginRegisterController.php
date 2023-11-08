<?php

namespace App\Http\Controllers\V1\Auth;


use Illuminate\Http\Request;
use App\Http\Requests\V1\UserRegisterRequest;
use App\Http\Requests\V1\UserLoginRequest;
use App\Http\Requests\V1\ForgotPasswordRequest;
use App\Http\Requests\V1\VerifyTokenRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\LoginRegisterService;

class LoginRegisterController extends Controller
{
    /** 
    * 
    */
    private $LoginRegisterService;

    public function __construct(LoginRegisterService $LoginRegisterService) {
        $this->LoginRegisterService = $LoginRegisterService;
    }

    public function register(UserRegisterRequest $request) {
        $response = $this->LoginRegisterService->register($request->all());
        return $response;
    }

    public function login(UserLoginRequest $request) {
        $credentials = $request->only('username', 'password');
        $response = $this->LoginRegisterService->login($credentials);
        return $response;
    }

    public function forgotPassword(ForgotPasswordRequest $request) {
        $response = $this->LoginRegisterService->forgotPassword($request->all());
        return $response;
    }

    public function verifyToken(VerifyTokenRequest $request) {
        $token = $request->token;
        $response = $this->LoginRegisterService->verifyToken($token);
        return $response;
    }

    public function logout(VerifyTokenRequest $request) {
        $response = $this->LoginRegisterService->logout($request->all());
        return $response;
    }

    public function logoutAll(VerifyTokenRequest $request) {
        $response = $this->LoginRegisterService->logoutAll($request->all());
        return $response;
    }
}