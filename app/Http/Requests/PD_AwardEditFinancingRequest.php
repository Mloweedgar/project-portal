<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PD_AwardEditFinancingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator()?true:false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:pd_award_financing,id',
            'financing_name' => 'required',
            'financing_start_date' => 'required',
            'financing_category_id' => 'required',
            'financing_amount' => 'required',
            'financing_party_id' => 'required'
        ];
    }
}
