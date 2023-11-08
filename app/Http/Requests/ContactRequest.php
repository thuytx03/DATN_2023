<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
                    case 'replied':
                        $replied = [
                            'name' => 'required',
                            'subject' => 'required',
                            'email' => 'required|email',
                            'phone'=> 'required|numeric|digits:10',
                            'message'=> 'required',
                            
                        ];
                        
                        break;
                        case 'sendContact':
                            $replied = [
                                'name' => 'required',
                                'subject' => 'required',
                                'email' => 'required|email',
                                'phone'=> 'required|numeric|digits:10',
                                'message'=> 'required',
                                
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
            'name.required' => 'Tên người gửi không được để trống!',
            'subject.required' => 'Tiêu đề không được để trống!',
            'email.required' => 'Email không được để trống!',
            'email.email'=> 'Email sai định dạng!',
            'phone.required'=> 'Số điện thoại không được để trống',
            'phone.numeric'=> 'Số điện thoại sai định dạng',
            'phone.digits'=> 'Số điện thoại sai định dạng',
            'message' => 'Nội dung không được để trống'
        ];
    }
}
