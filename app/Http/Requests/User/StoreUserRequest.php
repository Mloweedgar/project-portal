<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Illuminate\Support\Facades\Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users',
            'entity' => 'required|exists:entities,id',
            'role' => 'required|exists:roles,name',
            /*'telephone' => 'required',*/
            /*'country' => 'required|exists:prefixes,iso',*/
            'sections' => 'required_if:role,2,3,5,6,7|array|between:1,22',
            /*'projects' => 'required',*/
        ];
    }
}
