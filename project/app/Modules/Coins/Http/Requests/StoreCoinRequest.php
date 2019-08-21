<?php

namespace App\Modules\Coins\Http\Requests;

use App\Modules\Coins\Models\CoinTranslation;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StoreCoinRequest extends FormRequest
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
                $locale_alb = CoinTranslation::where('coin_id', $this->route('coin'))->where('locale', $locale)->first();
                if($this->has($locale.'.title') && !empty($locale_alb)) {
                    $rules[$locale . '.slug'] = 'nullable|string|unique:coins_translations,slug,' . $locale_alb->id;
                }
            }else{
                $rules[$locale.'.slug'] = 'nullable|string|unique:coins_translations,slug';
            }
        }

        $rules['visible'] = 'boolean';
        $rules['buy_link'] = 'nullable|string';
        $rules['graph_data'] = 'nullable|string';
        $rules['in_menu'] = 'boolean';

        return $rules;
    }
}
