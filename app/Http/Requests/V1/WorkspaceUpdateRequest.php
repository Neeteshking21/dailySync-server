<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\MasterApiRequest;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
// https://github.com/elegantweb/sanitizer
use Elegant\Sanitizer\Laravel\SanitizesInput;

class WorkspaceUpdateRequest extends MasterApiRequest
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
            'workspace_id' => "required|numeric|exists:workspaces,id,deleted_at,NULL,user_id,".auth()->id(),
            'workspace' => 'sometimes|array',
            'workspace.name' => 'string',
            'workspace_user' => 'sometimes|array',
            'workspace_user.*.subordinates' => 'sometimes|array',
            'workspace_user.*.subordinates.*' => 'integer',
            'workspace_user.*.role' => 'sometimes|array',
            'workspace_user.*.role.*' => 'integer',
            'workspace_user.*.access_type' => 'sometimes|string',
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
            'workspace_id.required' => 'workspace_id is Required!',
            'workspace_id.exists' => 'Workspace doesn\'t exists!',
            'workspace_id.numeric' => 'workspace_id should be a number!',
            'workspace.array' => 'workspace field should be a json',
            'workspace.name.string' => 'workspace name should be a string',
            'workspace_user.*.subordinates.*.numeric' => 'workspace subordinate should be a comma seprated string',
            'workspace_user.*.role/*.numeric' => 'workspace role should be a string',
            'workspace_user.*.access_type' => 'workspace access_type should be a string',
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
            'workspace_id' => 'trim',
            'workspace.name' => 'trim',
            'workspace_user.*.subordinate' => 'trim',
            'workspace_user.*.role' => 'trim',
            'workspace_user.*.access_type' => 'trim',
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();
            if(isset($data['workspace']) && empty($data['workspace'])){
                $validator->errors()->add('workspace.name', 'Workspace name is required');
            }
            if(isset($data['workspace_user']) && empty($data['workspace_user'])){
                $validator->errors()->add('workspace.name', 'Workspace user can\'t be empty');
            }
        });
    }
}
