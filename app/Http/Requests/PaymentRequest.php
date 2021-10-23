<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
    {      return[
            'money_amount' => 'required|min:1',

            'transfer_date' => 'required|date',
            'transferee_name' => 'required',

            'image' => 'required|image',
            'bank_no' => 'required|int',];



    }

    public function messages(){
        return [
          'money_amount.required' => 'أدخل مبلغ العمولة',
          'money_amount.min' => 'مبلغ العمولة لا يقل عن 1 ريال',
          'bankAccount_id.required' => 'أدخل اسم البنك',
          'transfer_date.required' => 'أدخل تاريخ التحويل',
          'transferee_name.required' => 'أدخل اسم المحول',
          'product_id.required' => 'أدخل رقم المنتج',
          'image.required' => 'ارفع صورة الحوالة',
          'image.image' => 'ارفع صورة ذات امتداد مناسب',


        ];
    }
}
