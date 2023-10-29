<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeatRequest extends FormRequest
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
     * @return array<string, mixed>
     */
     public function rules()
    {
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        switch ($this->method()) {
            case 'POST':
                switch ($currentAction) {
                    case 'store':
                        $rules = [
                            'room_id' => 'required',
                            'vip_quantity' => [
                                'required',
                                'numeric',
                                function ($attribute, $value, $fail) {
                                    if ($value % 10 !== 0) {
                                        $fail('Số ghế phải là số chẵn hàng chục.');
                                    }
                                },
                            ],
                            'standard_quantity' => [
                                'required',
                                'numeric',
                                function ($attribute, $value, $fail) {
                                    if ($value % 10 !== 0) {
                                        $fail('Số ghế thường phải là số chẵn hàng chục.');
                                    }
                                },
                            ],
                            'couple_quantity' => [
                                'required',
                                'numeric',
                                function ($attribute, $value, $fail) {
                                    if ($value % 10 !== 0) {
                                        $fail('Số ghế đôi phải là số chẵn hàng chục.');
                                    }
                                },
                            ],
                            'total_seats' => [
                                function ($attribute, $value, $fail) {
                                    if ($value > 100) {
                                        $fail('Tổng số ghế không được vượt quá 100 ghế.');
                                    }
                                },
                            ],
                        ];

                        break;
                    case 'update':
                        $rules = [
                            
                            'vip_quantity' => [
                                'required',
                                'numeric',
                                function ($attribute, $value, $fail) {
                                    if ($value % 10 !== 0) {
                                        $fail('Số ghế phải là số chẵn hàng chục.');
                                    }
                                },
                            ],
                            'standard_quantity' => [
                                'required',
                                'numeric',
                                function ($attribute, $value, $fail) {
                                    if ($value % 10 !== 0) {
                                        $fail('Số ghế thường phải là số chẵn hàng chục.');
                                    }
                                },
                            ],
                            'couple_quantity' => [
                                'required',
                                'numeric',
                                function ($attribute, $value, $fail) {
                                    if ($value % 10 !== 0) {
                                        $fail('Số ghế đôi phải là số chẵn hàng chục.');
                                    }
                                },
                            ],
                            'total_seats' => [
                                function ($attribute, $value, $fail) {
                                    if ($value > 100) {
                                        $fail('Tổng số ghế không được vượt quá 100 ghế.');
                                    }
                                },
                            ],
                        ];
                        break;
                }
                break;
            default:
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'room_id.required' => 'Vui lòng chọn phòng!',
            'vip_quantity.required' => 'Vui lòng nhập số ghế VIP!',
            'vip_quantity.numeric' => 'Số ghế VIP phải là một số!',
            'standard_quantity.required' => 'Vui lòng nhập số ghế thường!',
            'standard_quantity.numeric' => 'Số ghế thường phải là một số!',
            'couple_quantity.required' => 'Vui lòng nhập số ghế đôi!',
            'couple_quantity.numeric' => 'Số ghế đôi phải là một số!',
            'vip_quantity.custom' => 'Số ghế VIP phải là số chẵn hàng chục.',
            'standard_quantity.custom' => 'Số ghế thường phải là số chẵn hàng chục.',
            'couple_quantity.custom' => 'Số ghế đôi phải là số chẵn hàng chục.',
            'total_seats.custom' => 'Tổng số ghế không được vượt quá 100 ghế.',
        ];

    }
}
