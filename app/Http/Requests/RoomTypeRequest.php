<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomTypeRequest extends FormRequest
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
        $add = [];
        $edit = [];

        $check = $this->route()->getActionMethod();
        switch ($this->method()):
            case 'POST':
                switch ($check):
                    case 'store':
                        $add = [
                            'name' => 'required|unique:room_types',
                            'description' => 'required',
                            'slug' => 'required|unique:room_types',
                            'image' => 'required',
                        ];
                        break;
                    case 'update':
                        $edit = [
                            'name' => ['required',Rule::unique('room_types')->ignore($this->id)],
                            'description' => 'required',
                            'slug' => ['required',Rule::unique('room_types')->ignore($this->id)],
                            
                        ];
                        break;
                endswitch;
                break;
        endswitch;
        return $check === 'store' ? $add : $edit;
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên loại phòng không được để trống!',
            'description.required' => 'Mô tả không được để trống!',
            'slug.required' => 'Đường dẫn không được để trống!',
            'image.required' => 'Hình ảnh không được để trống!',
            'name.unique' => 'Tên loại phòng đã tồn tại!',
            'slug.unique' => 'Tên đường dẫn phòng đã tồn tại!',
        ];
    }
}
