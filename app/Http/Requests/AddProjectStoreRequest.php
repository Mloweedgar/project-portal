<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class AddProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Illuminate\Support\Facades\Auth::user()->canCreate();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_name' => 'required|unique:projects,name',
        ];
    }
}
