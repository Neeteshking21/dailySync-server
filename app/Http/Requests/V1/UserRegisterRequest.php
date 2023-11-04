<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\MasterApiRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\RespondsWithHttpStatus;

class UserRegisterRequest extends MasterApiRequest
{
    use RespondsWithHttpStatus;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'profileImg' => ['image', 'mimes:png, jpg, jpeg, gif']
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username is required!',
            'username.unique' => 'Username already exists!',
            'email.required' => 'Email is required!',
            'email.unique' => 'Email already exists!',
            'name.required' => 'Name is required!',
            'password.required' => 'Password is required!'
        ];
    }

    /**
     * Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'name' => 'trim',
            'username' => 'trim|lowercase',
            'email' => 'trim|lowercase',
            'password' => 'trim',
        ];
    }

     /**
     * Validation Error for response for Apis.
     *
     * @return array
     */

    public function failedValidation(Validator $validator)

    {
        
        throw new HttpResponseException($this->failure('Validation errors', $validator->errors(), 422));

    }
}
