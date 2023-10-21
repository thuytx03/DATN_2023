<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Province;

class ProvinceRequest extends FormRequest
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
        $check = $this->route()->getActionMethod();

    switch ($this->method()) {
        case 'POST':
        case 'GET':
            switch ($check) {
                case 'store':
                    return [
                        'name' => 'required|unique:provinces',
                        'description' => 'required',
                        'status' => 'required'
                    ];
                case 'update':
                     // Assuming you're using a route model binding
                    $province = Province::find($this->route('id'));
                    return [
                        'name' => [
                            'required',
                            Rule::unique('provinces')->ignore($province->id),
                        ],
                        'description' => 'required',
                        'status' => 'required'
                    ];
            }
            break;
    }
    return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'description.required' => 'Thông tin bổ sung không được để trống!',
            'name.unique' => 'Tên khu vực đã tồn tại!',
            'status.required' => 'Trạng thái không được để trống!'
        ];
    }
}
