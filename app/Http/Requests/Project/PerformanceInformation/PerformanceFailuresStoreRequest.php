<?php

namespace App\Http\Requests\Project\PerformanceInformation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PerformanceFailuresStoreRequest extends FormRequest
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
            'title' => 'required|max:255',
            'category_failure' => 'required|exists:pi_performance_failures_category,id',
            'number_events' => 'required|numeric',
            'penalty_abatement_contract' => 'required',
            /*'penalty_abatement_imposed' => 'required',*/
            'penalty_abatement_imposed_yes_no' => 'required',
        ];
    }
}
