<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
                            'name' => 'required|unique:rooms',
                            'image' => 'required',
                        ];
                        break;
                    case 'update':
                        $edit = [
                            'name' => ['required',Rule::unique('rooms')->ignore($this->id)],
                            'description' => 'required',
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
            'name.required' => 'Tên phòng không được để trống!',
            'name.unique' => 'Tên phòng đã tồn tại!',
            'image.required' => 'Hình ảnh không được để trống!',
        ];
    }
}
