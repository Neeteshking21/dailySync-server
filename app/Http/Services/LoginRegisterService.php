<?php

namespace App\Http\Services;

use App\Models\User;
use App\Traits\RespondsWithHttpStatus;

class LoginRegisterService {
    use RespondsWithHttpStatus;
    
    public function __construct() {

    }

    public function register($params) {
        try {
            return $this->success('succes msg', [$params]);

        }catch(\Exception $e) {
            $this->failure($e->getMessage(), 500);
        }
    }

    public function login($params) {

    }

    public function forgotPassword($params) {

    }

    public function verifyOTP($params) {
        
    }
}