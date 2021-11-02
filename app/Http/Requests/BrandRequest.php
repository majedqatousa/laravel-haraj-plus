<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
                return[
                    // 'image' => 'required|image',
                    'link' => 'nullable|url',
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'image' => 'image',
                    'link' => 'nullable|url',
                ];

            default:break;
        }



    }

    public function messages(){
        return[
          'image.required' => 'قم برفع صورة',
          'image.image' => 'اختر صورة ذات امتداد مناسب',
        ];
    }


}
