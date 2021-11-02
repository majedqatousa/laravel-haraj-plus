<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
        switch ($this->method()){
            case 'GET':
            case 'DELETE':
                return [];

            case 'POST':
                return [
                    // 'logo' => 'required|image',
                    'number' => 'required|numeric',
                    'iban_number' => 'required|string:24',
                    'name' => 'required',


                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'logo' => 'image',
                    'number' => 'required|numeric',
                    'iban_number' => 'required|string:24',
                    'name' => 'required',

                ];

        }
    }

    public function messages(){
        return [
            'logo.required' => 'حقل الصورة مطلوب',
            'logo.image'  => 'ارفع صورة ذات امتداد مناسب',
            'number.required' => 'حقل رقم الحساب مطلوب',
            'number.numeric' => 'حقل رقم الحساب عبارة عن أرقام فقط',
            'iban_number.required' => 'حقل رقم الايبان مطلوب',
            'iban_number.string' => 'حقل الايبان عبارة عن نص مكون من حروف وأرقام',
            'name.required' => 'حقل اسم البنك مطلوب',

        ];
    }
}
