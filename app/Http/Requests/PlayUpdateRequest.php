<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'int|required|exists:plays',
            'score_left' => 'int|min:0',
            'score_right' => 'int|min:0'
        ];
    }
}
