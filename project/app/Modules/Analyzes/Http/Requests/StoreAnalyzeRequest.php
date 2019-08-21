<?php

namespace App\Modules\Analyzes\Http\Requests;

use App\Modules\Analyzes\Models\AnalyzeTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreAnalyzeRequest extends FormRequest
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
            $rules[$locale . '.mini_description'] = 'nullable|string';
            $rules[$locale . '.picture_description'] = 'nullable|string';
            $rules[$locale . '.meta_title'] = 'nullable|string';
            $rules[$locale . '.meta_description'] = 'nullable|string|max:255';
            $rules[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = AnalyzeTranslation::where('analyze_id', $this->route('analyze'))->where('locale', $locale)->first();
                if ($this->has($locale . '.title') && !empty($locale_alb)) {
                    $rules[$locale . '.slug'] = 'nullable|string|unique:analyzes_translations,slug,' . $locale_alb->id;
                }
                $rules['file'] = 'nullable|file';
            } else {
                $rules['file'] = 'required|file';
                $rules[$locale . '.slug'] = 'nullable|string|unique:analyzes_translations,slug';
            }
        }

        $rules['visible'] = 'boolean';
        $rules['is_popular'] = 'boolean';
        $rules['category_id'] = 'required|exists:analyzes_categories,id';
        $rules['next_article_id'] = 'nullable|exists:analyzes,id';
        $rules['source'] = 'nullable|string';
        $rules['created_at'] = 'string';


        return $rules;
    }
}
