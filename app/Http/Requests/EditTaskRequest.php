<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Illuminate\Support\Facades\Auth::user()->isAdmin() ||  \Illuminate\Support\Facades\Auth::user()->isProjectCoordinator());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if( \Illuminate\Support\Facades\Auth::user()->isProjectCoordinator() ){
            return [
                'id' => 'required|exists:tasks,id',
                'comment' => 'required'
            ];
        }
        else{
            return [
                'id' => 'required|exists:tasks,id',
                'name' => 'required|max:255'
            ];
        }


    }
}
