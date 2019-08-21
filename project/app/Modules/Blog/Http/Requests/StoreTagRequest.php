<?php

namespace App\Modules\Blog\Http\Requests;

use App\Modules\Blog\Models\BlogTagTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreTagRequest extends FormRequest
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
            $rules[$locale . '.meta_title'] = 'nullable|string';
            $rules[$locale . '.meta_description'] = 'nullable|string';
            $rules[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = BlogTagTranslation::where('tag_id', $this->route('blog_tag'))->where('locale', $locale)->first();
                if ($this->has($locale . '.title') && !empty($locale_alb)) {
                    $rules[$locale . '.slug'] = 'nullable|string|unique:blog_tags_translations,slug,' . $locale_alb->id;
                }
            } else {
                $rules[$locale . '.slug'] = 'nullable|string|unique:blog_tags_translations,slug';
            }
        }

        $rules['visible'] = 'boolean';
        $rules['in_index'] = 'boolean';

        return $rules;
    }
}
