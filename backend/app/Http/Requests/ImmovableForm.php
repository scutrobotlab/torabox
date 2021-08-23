<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImmovableForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'immovable_kind_id' => 'required|exists:App\Models\ImmovableKind,id',
            'need_approval' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '缺少名称',
            'immovable_kind_id.required' => '缺少种类',
            'immovable_kind_id.exists' => '种类不存在',
            'need_approval.required' => '缺少审批需求',
            'need_approval.boolean' => '审批需求必须为布尔值',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'message' => $validator->errors()->first(),
        ], 400));
    }
}
