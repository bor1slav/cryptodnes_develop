<?php

namespace App\Modules\Analyzes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrontAnalyzeComment extends FormRequest
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
        return [
            'comment' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'parent_id' => 'nullable',
            'article_id' => 'required|exists:analyzes,id',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
