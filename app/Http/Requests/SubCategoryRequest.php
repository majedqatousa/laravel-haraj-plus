<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
                    'name' => 'required',
                    'parent_id' => 'required',
                    'order' => 'required|numeric|unique:categories,order|min:1',

                ];

            case 'PUT':
            case 'PATCH':
                
                    $category = $this->route('sub_category');
                  
                return [
                    'image' => 'image',
                    'name' => 'required',
                    'parent_id' => 'required',
                    'order' => 'required|numeric|min:1|unique:categories,order,'.$category,


                ];

        }
    }

    public function messages(){
        return[
            'image.required' => 'حقل الصورة مطلوب',
            'image.image' => 'أدخل صورة ذات امتداد مناسب',
            'name.required' => 'أدخل اسم القسم',
            'parent_id.required' => 'اختر قسم رئيسي',
            'order.required' => 'ادخل الترتيب',
            'order.numeric' => 'الترتيب لابد ان يكون رقم ',
            'order.min' => ' الترتيب لابد ان يكون رقم اكبر من 1',
            'order.unique'=>'يوجد قسم بهذا الترتيب'
        ];


    }


}
