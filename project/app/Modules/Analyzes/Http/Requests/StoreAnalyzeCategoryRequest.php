<?php

namespace App\Modules\Analyzes\Http\Requests;

use App\Modules\Analyzes\Models\AnalyzeCategoryTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreAnalyzeCategoryRequest extends FormRequest
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
            $rules[$locale . '.meta_description'] = 'nullable|string|max:255';
            $rules[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = AnalyzeCategoryTranslation::where('category_id', $this->route('analyzes_category'))->where('locale', $locale)->first();
                if ($this->has($locale . '.title') && !empty($locale_alb)) {
                    $rules[$locale . '.slug'] = 'nullable|string|unique:analyzes_categories_translations,slug,' . $locale_alb->id;
                }
            } else {
                $rules[$locale . '.slug'] = 'nullable|string|unique:analyzes_categories_translations,slug';
            }
        }

        $rules['visible'] = 'boolean';
        $rules['coin_id'] = 'required|exists:coins,id';

        return $rules;
    }
}
