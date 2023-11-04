<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFoodRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'order_end' => 'required|date|after:now',
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Email không để trống",
            "order_end.required" => "Ngày nhận không để trống",
            "order_end.after" => "Ngày nhận không hợp lệ",
        ];
    }   
}
