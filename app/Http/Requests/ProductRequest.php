<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'  => 'required',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required'  => ':attributeは必須項目です。',
        ];
    }

    public function attributes()
    {
        return [
            'name'      => '名称',
            'price'     => '単価',
            'unit_id'   => '単位',
            'summary'   => '概要'
        ];
    }
}
