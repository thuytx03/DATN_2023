<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryRequest extends FormRequest
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
                            'name' => 'required|unique:country',
                            'image' => 'required'
                            
                        ];
                        break;
                    case 'update':
                        $edit = [
                            'name' => ['required',Rule::unique('country')->ignore($this->id)],
                            
                            
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
            'name.required' => 'Tên không được để trống!',
            'image.required' => 'Ảnh không được để trống!',
            'name.unique' => 'Tên không được trùng!',
        ];
    }
}
