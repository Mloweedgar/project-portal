<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project\ProjectDetails\PD_Document;

class SendOnlineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max = count(PD_Document::getRequestDocumentsList())-1;

        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'document' => 'required|digits_between:0,'.$max,
            'description' => 'required'
        ];
    }
}
