<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NavItemPageStoreRequest extends FormRequest
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
            'id' => 'required|Integer',
            'name' => 'required|max:255',
            'link' => 'required',
            'position' => 'required|Integer'
        ];

    }
}
