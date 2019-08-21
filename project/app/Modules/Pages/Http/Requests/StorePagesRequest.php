<?php

namespace App\Modules\Pages\Http\Requests;

use App\Modules\Pages\Models\PageTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StorePagesRequest extends FormRequest
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
        $rules = [];


        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $rules[$locale . '.title'] = 'required|string';
            $rules[$locale . '.description'] = 'nullable|string';
            $rules[$locale . '.meta_title'] = 'nullable|string';
            $rules[$locale . '.meta_description'] = 'nullable|string';
            $rules[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = PageTranslation::where('page_id', $this->route('page'))->where('locale', $locale)->first();
                if ($this->has($locale . '.title') && !empty($locale_alb)) {
                    $rules[$locale . '.slug'] = 'nullable|string|unique:pages_translations,slug,' . $locale_alb->id;
                }
            } else {
                $rules[$locale . '.slug'] = 'nullable|string|unique:pages_translations,slug';
            }
        }

        $rules['visible'] = 'boolean';
        $rules['type_id'] = 'required|exists:pages_types,id';

        return $rules;
    }
}
