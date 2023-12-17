<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeatTypeRequest extends FormRequest
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
                            'name' => 'required|unique:seat_types',
                            // 'price' => 'required|numeric',
                            'slug' => 'unique:seat_types',
                        ];
                        break;
                    case 'update':
                        $rules = [
                            'name' => ['required',Rule::unique('seat_types')->ignore($this->id)],
                            'slug' => ['required',Rule::unique('seat_types')->ignore($this->id)],
                            // 'price' => 'required|numeric',
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
            'name.required' => 'Tên loại ghế không được để trống!',
            'name.unique' => 'Tên loại ghế đã tồn tại!',
            // 'price.required' => 'Giá loại ghế không được để trống!',
            // 'price.numeric' => 'Giá loại phải là số!',
            'slug.unique' => 'Tên đường dẫn ghế đã tồn tại!',
        ];
    }
}
