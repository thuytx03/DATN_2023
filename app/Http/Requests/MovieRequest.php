<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
                    case 'update' :
                        $rules = [
                            'name' => 'required',
                            'language' => 'required|string',
                            'status' => 'required',
                            'trailer' => 'required:string',
                            'director' => 'required:string',
                            'actor' => 'required:string',
                            'duration' => 'required',
                            'start_date' => 'required',
                            'manufacturer' => 'required:string',
                            'genre_id' => 'required',
                            'country_id' => 'required'

                        ];
                        break;
                    case 'store' :
                        $rules = [
                            'name' => 'required',
                            'language' => 'required|string',
                            'status' => 'required',
                            'poster' => 'required',
                            'trailer' => 'required',
                            'director' => 'required',
                            'actor' => 'required',
                            'duration' => 'required',
                            'start_date' => 'required',
                            'manufacturer' => 'required',
                            'genre_id' => 'required',
                            'country_id' => 'required'
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
            'name.required' => 'Vui lòng nhập tên',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng nhập slug khác.',
            'language.required' => 'Vui lòng nhập ngôn ngữ',
            'status.required' => 'Vui lòng nhập trạng thái',
            'poster.required' => 'Vui lòng nhập poster',
            'trailer.required' => 'Vui lòng nhập trailer phim',
            'director.required' => 'Vui lòng nhập đạo diễn',
            'actor.required' => 'Vui lòng nhập diên viên',
            'duration.required' => 'Vui lòng nhập thời lượng phim',
            'start_date.required' => 'Vui lòng nhập ngày khởi chiếu',
            'manufacturer.required' => 'Vui lòng nhập nhà sáng tác',
            'genre_id.required' => 'Vui lòng nhập thể loại phim',
            'country_id.required' => 'Vui lòng nhập quốc gia'
        ];
    }
}
