<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConsumableRecordForm extends FormRequest
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
            'consumable_id' => 'required|exists:App\Models\Consumable,id',
            'number' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'consumable_id.required' => '缺少消耗品',
            'consumable_id.exists' => '消耗品不存在',
            'number.required' => '缺少数量',
            'number.integer' => '数量必须为整数',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'message' => $validator->errors()->first(),
        ], 400));
    }
}
