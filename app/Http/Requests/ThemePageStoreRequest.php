<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemePageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Illuminate\Support\Facades\Auth::user()->isAdmin() || \Illuminate\Support\Facades\Auth::user()->isIT();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'theme' => 'required|Integer',
            'primary_color' => 'required|max:22',
            'secondary_color' => 'required|max:22',
            'title_font_family' => 'required|max:255',
            'title_font_size' => 'required|max:4',
            'title_letter_spacing' => 'required|max:3',
            'subtitle_font_size' => 'required|max:4',
            'subtitle_letter_spacing' => 'required|max:3',
            'body_font_family' => 'required|max:255',
            'body_font_size' => 'required|max:4',
            'body_line_height' => 'required|max:4',
            'body_spacing_paragraphs' => 'required|max:4',
        ];

    }
}
