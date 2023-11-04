<?php

namespace App\Http\Controllers\V1\Auth;


use Illuminate\Http\Request;
use App\Http\Requests\V1\UserRegisterRequest;
use App\Http\Requests\V1\UserLoginRequest;
use App\Http\Requests\V1\ForgotPasswordRequest;
use App\Http\Requests\V1\VerifyOtpRequest;
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
        $response = $this->LoginRegisterService->login($request->all());
        return $response;
    }

    public function forgotPassword(ForgotPasswordRequest $request) {
        $response = $this->LoginRegisterService->forgotPassword($request->all());
        return $response;
    }

    public function verifyOTP(VerifyOtpRequest $request) {
        $response = $this->LoginRegisterService->verifyOTP($request->all());
        return $response;
    }
}