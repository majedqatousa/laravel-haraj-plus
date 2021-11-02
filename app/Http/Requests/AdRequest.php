<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
                    // 'image' => 'required|image',
                    'link' => 'required|url',
                    'description' => 'nullable',
                    'position' => 'required',


                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'image' => 'image',
                    'link' => 'required|url',
                    'description' => 'nullable',
                    'position' => 'required',


                ];

        }
    }

    public function messages(){
        return [
            'image.required' => 'حقل الصورة مطلوب',
            'image.image'  => 'ارفع صورة ذات امتداد مناسب',
            'link.required' => 'حقل الرابط مطلوب',
            'link.url' => 'أدخل رابط مناسب',
            'position.required' => 'حقل الموضع مطلوب',
        ];
    }
}
