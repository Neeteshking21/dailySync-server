<?php

namespace App\Http\Services;

use App\Jobs\ProcessMails;
use App\Models\User;
use App\Models\Verifications;
use App\Mail\verifyMail;
use Illuminate\Http\Response;
use App\Traits\RespondsWithHttpStatus;
use App\Traits\AttachmentTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoginRegisterService {
    use RespondsWithHttpStatus, AttachmentTrait;
    
    public function __construct() {

    }

    public function register($params):Response {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->first_name = $params['first_name'];
            $user->middle_name = $params['middle_name'] ?? null;
            $user->last_name = $params['last_name'] ?? null;
            $user->username = $params['username'];
            $user->email = $params['email'];
            $user->password = $params['password'];
            // $user->profileImg = isset($params['profileImg']) ? $this->storeAttachment($params['profileImg'], "//images//") : null;
            $userData = $user->save();
            if($userData){
                $vToken = now()->format('YmdHisv') . '-' . Str::random(6);
                $verification = new Verifications();
                $verification->user_id = $user->id;
                $verification->token = $vToken;
                $save_response = $verification->save();
                if(!$save_response) {
                    throw new \Exception("Verification token creation failed!");
                }

                $mail_details = array(
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'token' => $vToken
                );
                dispatch(new ProcessMails($user->email, new verifyMail($mail_details)));
                // $is_sent = Mail::to($user->email)->send(new verifyMail($mail_details));
                // if(!$is_sent) {
                //     throw new \Exception("Verification Mail failed");
                // }
               /*  $token = $user->createToken('DailySyncApiV1')->accessToken;
                $response_data = array(
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'token' => $token
                ); */
                DB::commit();
                return $this->success(
                   'Account created, verification mail sent successfully'
                );
            }
            throw new \Exception('Failled to register user, Please try again');

        }catch(\Exception $e) {
            DB::rollback();
            return $this->failure($e->getMessage(), [], 401);
        }
    }

    public function login($params) {
        try {
            if (Auth::attempt($params)) {
                $user = Auth::User();
                $token = $user->createToken('DailySyncApiV1')->accessToken;
        
                return $this->success(
                    'User logged in successfully',
                    ['token' => $token]
                );
            } else {
                throw new \Exception('Invalid user credentials');
            }

        }catch(\Exception $e) {
            return $this->failure($e->getMessage(), 401);
        }
    }

    
    public function verifyToken($token) {
        try {
            $verification = Verifications::where([['token', $token], ['is_verified', 0]])->first();
            if($verification) {
                $user = User::where('id', $verification->user_id)->update(['email_verified_at'=> now()]);
                $verification->is_verified = 1;
                $verification->save();
                if(!$user) {
                    throw new \Exception('Failed to verificaton token!');
                }
                return $this->success(
                    'Account verified, please login now.'
                );
            }
            throw new \Exception('Page not found!');
        }catch(\Exception $e) {
            return $this->failure($e->getMessage(), [], 404);
        }
    }
  
    
    public function forgotPassword($params) {

    }

    public function logout($request) {
        try{
            $user = Auth::user();
            $response = $user->token()->revoke();
            if(!$response){
                throw new \Exception('Failed to logout, please try again!');
            }
            return $this->success(
                "Logged out successfully"
            );
        }catch(\Exception $e){
            return $this->failure($e->getMessage(), 501);
        }
    }
    public function logoutAll($request) {
        try{
            $user = Auth::user();
            $response = $user->tokens->each(function ($token, $key) {
                $token->revoke();
            });
        
            if(!$response){
                throw new \Exception('Failed to logout, please try again!');
            }
            return $this->success(
                "Logged out successfully"
            );
        }catch(\Exception $e){
            return $this->failure($e->getMessage(), 501);
        }
    }
}