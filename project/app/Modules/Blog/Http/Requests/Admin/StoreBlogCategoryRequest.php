<?php

namespace App\Modules\Blog\Http\Requests\Admin;

use App\Modules\Blog\Models\BlogCategoryTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreBlogCategoryRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [];


        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $rules[$locale . '.title'] = 'required|string';
            $rules[$locale . '.description'] = 'nullable|string';
            $rules[$locale . '.meta_title'] = 'nullable|string';
            $rules[$locale . '.meta_description'] = 'nullable|string|max:255';
            $rules[$locale . '.meta_keywords'] = 'nullable|string';

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $rules[$locale . '.slug'] = 'nullable|string|unique:blog_categories_translations,slug,' . $this->route('blog_category');
            } else {
                $rules[$locale . '.slug'] = 'nullable|string|unique:blog_categories_translations,slug';
            }

            if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
                $locale_alb = BlogCategoryTranslation::where('category_id', $this->route('blog_category'))->where('locale', $locale)->first();
                if($this->has($locale.'.title') && !empty($locale_alb)) {
                    $rules[$locale . '.slug'] = 'nullable|string|unique:blog_categories_translations,slug,' . $locale_alb->id;
                }
            }else{
                $rules[$locale.'.slug'] = 'nullable|string|unique:blog_translations,slug';
            }
        }

        $rules['visible'] = 'boolean';
        $rules['in_menu'] = 'boolean';
        $rules['in_index'] = 'boolean';
        $rules['parent_id'] = 'nullable|exists:blog_categories,id';

        return $rules;
    }
}
