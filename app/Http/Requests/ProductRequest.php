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
        switch($this->method())
        {

        case 'POST':
        {
            
            return[
                'name' => 'required',
                'status'=>'required',
                'price'=>'required|max:11',
                'city_id' => 'required',
                'category_id'=>'required',
                // "main_image"=>'required|image',
                'is_checked'=>'required',
                'description'=>'required|max:15000',
                // 'video_url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            ] ;
        }
        case 'PUT':
        case 'PATCH':
        {

            return [
                'name' => 'required',
                'status'=>'required',
                'price'=>'required|max:11',
                'description'=>'required|max:15000',
                'main_image'=>'nullable:image',
                'video_url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',


            ];
        }
        default:break;
    }

    }
    
    public function messages(){
        return[
            'video_url.regex' => 'من فضلك ادخل رابط صحيح',
            
        ];


    }
}
