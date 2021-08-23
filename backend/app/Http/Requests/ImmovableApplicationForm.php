<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ImmovableApplicationForm extends FormRequest
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
            'immovable_id' => 'required|exists:App\Models\Immovable,id',
            'action' => ['required', Rule::in(['lend', 'return'])],
        ];
    }

    public function messages()
    {
        return [
            'immovable_id.required' => '缺少固定资产',
            'immovable_id.exists' => '固定资产不存在',
            'action.required' => '缺少行为',
            'action.in' => '行为不存在',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'message' => $validator->errors()->first(),
        ], 400));
    }
}
