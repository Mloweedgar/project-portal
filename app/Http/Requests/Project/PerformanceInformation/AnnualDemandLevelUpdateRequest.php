<?php

namespace App\Http\Requests\Project\PerformanceInformation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AnnualDemandLevelUpdateRequest extends FormRequest
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
            'demmands' => 'required',
        ];
    }
}
