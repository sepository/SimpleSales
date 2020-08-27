<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name'          => 'required',
            'postal_code'   => 'max:10',
            'address'       => 'max:300',
            'tel_no'        => 'max:20'
        ];
    }

    public function messages()
    {
        return [
            'required'  => ':attributeは必須項目です。',
            'max'       => ':attributeは:max文字以内にしてください。'
        ];
    }

    public function attributes()
    {
        return [
            'name'          => '名称',
            'postal_code'   => '郵便番号',
            'address'       => '住所・宛先',
            'tel_no'        => '電話番号'
        ];
    }
}
