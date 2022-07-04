<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogoPageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Illuminate\Support\Facades\Auth::user()->isAdmin() || \Illuminate\Support\Facades\Auth::user()->isIT();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'file' => 'dimensions:min_width=200, min_height=200|image|required'
        ];

    }
}
