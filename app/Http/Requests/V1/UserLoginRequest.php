<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\MasterApiRequest;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends MasterApiRequest
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
            //
            'username' => 'required',
            'password' => 'required'
        ];
    }
    
    /**
     * Can write custom messages on validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
            'username.required' => 'Username is required!',
            'password.required' => 'Password is required!',
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
            'username' => 'trim|lowercase',
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
