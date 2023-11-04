<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\MasterApiRequest;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyOtpRequest extends MasterApiRequest
{
    use RespondsWithHttpStatus;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'otp' => 'required|number'
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
            'otp.required' => 'OTP is required!',
            'otp.number' => 'OTP should be a number!'
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
            //
            'otp' => 'trim'
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
