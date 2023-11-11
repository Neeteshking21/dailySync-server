<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\MasterApiRequest;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
// https://github.com/elegantweb/sanitizer
use Elegant\Sanitizer\Laravel\SanitizesInput;

class WorkspaceDestroyRequest extends MasterApiRequest
{
    use RespondsWithHttpStatus, SanitizesInput;

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
            'workspaces' => 'required|array',
            'workspaces.*' => 'numeric|exists:workspaces,id'
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
            'workspaces.required' => 'Workspace Ids are required',
            'workspaces.*.numeric' => 'Workspace Ids should be numeric',
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
            'workspaces' => 'trim',
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
