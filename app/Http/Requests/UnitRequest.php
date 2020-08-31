<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'name' => 'required|unique:units|max:10'
        ];
    }

    public function messages()
    {
        return [
            'required'  => ':attributeは必須項目です。',
            'unique'    => '同じ:attributeの単位が既に存在します。',
            'max'       => ':attributeは:max文字以内にしてください。'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '名称'
        ];
    }
}
