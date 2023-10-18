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
                            'manufacturer' => 'required'
                        ];
                        break;
                }
                break;
            default:
                break;
        }
        return $rules;
    }
}
