<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoucherRequest extends FormRequest
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
                            'code' => 'required|unique:vouchers|min:6|max:15',
                            'type' => 'required',
                            'value' => 'required|integer',
                            'quantity' => 'required|integer',
                            'start_date' => 'required',
                            'end_date' => 'required',
                        ];
                        break;
                    case 'update':
                        $rules = [
                            'code' => ['required',Rule::unique('vouchers')->ignore($this->id),'min:6','max:15'],
                            'type' => 'required',
                            'value' => 'required|integer',
                            'quantity' => 'required|integer',
                            'start_date' => 'required',
                            'end_date' => 'required',
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
            'code.required' => 'Vui lòng nhập tên mã giảm giá.',
            'code.unique' => 'Mã giảm đã tồn tại. Vui lòng nhập mã khác.',
            'code.min' => 'Mã giảm giá tối thiểu từ 6 ký tự.',
            'code.max' => 'Mã giảm giá tối đa 15 ký tự.',
            'type.required' => 'Vui lòng nhập loại mã giảm giá.',
            'value.required' => 'Vui lòng nhập giá trị mã giảm giá.',
            'value.integer' => 'Giá trị giảm giá phải là số.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng mã giảm giá phải là số.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.required' => 'Vui lòng nhập ngày hết hạn.',
        ];
    }
}
