<?php

namespace App\Http\Requests\Project\PerformanceInformation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KeyPerformanceIndicatorsTypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  (Auth::user()->isAdmin() || Auth::user()->isDataEntry());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique_with:pi_key_performance_indicators_kpi_types,unit',
            'unit' => 'required',
        ];
    }
}
