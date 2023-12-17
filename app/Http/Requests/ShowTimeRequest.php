<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Symfony\Component\Translation\t;

class ShowTimeRequest extends FormRequest
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
                    case 'update' :
                        $rules = [
                            'room_id' => 'required',
                            'movie_id' => 'required',
                            'status' => 'required',
                            'start_date' => 'required',
                            'end_date' => 'required',
                            'thuong' => 'required|integer|numeric|min:0',
                            'vip' => 'required|integer|numeric|min:0',
                            'doi' => 'required|integer|numeric|min:0',

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
            'room_id.required' => 'Vui lòng chọn phòng chiếu',
            'movie_id.required' => 'Vui lòng chọn phim chiếu',
            'start_date.required' => 'Vui lòng chọn thời gian chiếu',
            'end_date.required' => 'Vui lòng chọn thời gian kết thúc',
            'thuong.required' => 'Vui lòng giá ghế thường.',
            'thuong.integer' => 'Giá ghế thường phải là số nguyên.',
            'thuong.min' => 'Giá ghế thường không được nhỏ hơn 0.',
            'vip.required' => 'Vui lòng giá ghế vip.',
            'vip.integer' => 'Giá ghế vip phải là số nguyên.',
            'vip.min' => 'Giá ghế vip không được nhỏ hơn 0.',
            'doi.required' => 'Vui lòng giá ghế đôi.',
            'doi.integer' => 'Giá ghế đôi phải là số nguyên.',
            'doi.min' => 'Giá ghế đôi không được nhỏ hơn 0.',
        ];
    }
}
