<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectInformationEditCoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::user()->isAdmin()||Auth::user()->isProjectCoordinator()?true:false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'project_id' => 'required',
            'sectors' => 'required',
            'regions' => 'required',
            'stage' => 'required|exists:stages,id',
            'sponsor' => 'required|exists:entities,id',
            'project_value_usd' => 'required',
            'project_value_second' => 'required'
        ];

        return $rules;
    }
}
