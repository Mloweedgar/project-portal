<?php

namespace App\Http\Requests\Project\ProjectDetails;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PD_ContractTerminationEditRequest extends FormRequest
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
            'id' => 'required|exists:pd_contract_termination,id',
            'party_type' => 'required|in:concessionaire,authority',
            'name' => 'required|max:255',
            'description' => 'required',
            'termination_payment' => 'required'
        ];
    }
}
