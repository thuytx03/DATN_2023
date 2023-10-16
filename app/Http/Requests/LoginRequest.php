<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
                            'name' => 'required',
                            'email' => 'required|unique:users',
                            'password' => 'required',
                        ];
                        break;
                    case 'update':
                        $edit = [
                            'name' => 'required',
                            'email' => 'required|unique:users',
                            'password' => 'required',
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
            'email.required' => 'Email không được để trống!',
            'password.required' => 'Password không được để trống!',
            'email.unique' => 'Email đã tồn tại!'
        ];
    }
}
