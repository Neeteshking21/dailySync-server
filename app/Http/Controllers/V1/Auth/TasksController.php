<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\TasksService;

class RegisterRequest extends Request {
    public function rules(): array {
        return [
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'cpassword' => 'required',
            'profileImg' => ['image', 'required', 'mimes:png, jpg, jpeg, gif']
        ];
    }
}

class LoginRegisterController extends Controller
{
    /** 
    * 
    */
    private $TasksService;

    public function __construct(TasksService $TasksService) {
        $this->TasksService = $TasksService;
    }

    public function index(RegisterRequest $request) {
        $response = $this->TasksService->getTasks($request->all());
        return $response;
    }
}