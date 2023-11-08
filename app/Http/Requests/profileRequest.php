<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class profileRequest extends FormRequest
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
        $replied = [];

        $check = $this->route()->getActionMethod();
        switch ($this->method()):
            case 'POST':
                switch ($check):
                    case 'change_password':
                        $replied = [
                            'oldPassword' => 'required',
                            'password' => 'required|confirmed:second_password',
                        ];

                    break;
                    case 'edit_profile':
                        $replied = [
                            'phone' => 'numeric|regex:/^\d{10}$/',
                        ];

                    break;
                endswitch;
            break;
        endswitch;
        return $replied;
    }
    public function messages()
    {
        return [
            'oldPassword.required' => 'Mật khẩu cũ không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
            'phone.numeric' => 'Số điện thoại sai định dạng',
            'phone.regex' => 'Số điện thoại sai định dạng',
            
        ];
    }
}
