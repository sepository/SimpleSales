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
        return $this->getRules($this->all());
    }

    public function getRules($data)
    {
        $rules = [
            'name'      => 'required|max:100',
            'price'     => 'required|numeric|max:9999999',
            'summary'   => 'max:300',
        ];

        if ($data['unit_id']) {
            $rules['unit_id'] = 'exists:units,id';
        }

        return $rules;
    }
}
