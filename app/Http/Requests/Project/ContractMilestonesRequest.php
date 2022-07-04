<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContractMilestonesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return (Auth::user()->isAdmin());
        return (Auth::user()->isAdmin()||Auth::user()->isProjectCoordinator()?true:false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required',
            'milestone_type' => 'required',
            'date' => 'required_without:deadline',
            'deadline' => 'required_without:date'
        ];
    }
}
