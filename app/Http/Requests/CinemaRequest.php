<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cinema;
use Illuminate\Validation\Rule;

class CinemaRequest extends FormRequest
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
                            'name' => 'required|unique:cinemas',
                            'description' => 'required',
                            'status' => 'required'
                        ];
                    case 'update':
                        // Assuming you're using a route model binding
                        $cinema = Cinema::find($this->route('id'));
                        return [
                            'name' => [
                                'required',
                                Rule::unique('cinemas')->ignore($cinema->id),
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
            'name.required' => 'Tên rạp không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'description.required' => 'Thông tin bổ sung không được để trống!',
            'name.unique' => 'Tên rạp đã tồn tại!',
            'status.required' => 'Trạng thái không được để trống!'
        ];
    }
}
