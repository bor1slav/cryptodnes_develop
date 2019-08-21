<?php

namespace Charlotte\Administration\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Setting extends Model implements HasMedia {

    use HasMediaTrait, Translatable;

    public $translatedAttributes = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field', 'value'
    ];


    public function getFormModel(): Setting {
        $eloquent = new Setting();
        $translations = [];

        //create translation classes, we will add the to the setting model afterwards
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $translation = new SettingTranslation();
            $translation->setAttribute('locale', $locale);
            $translations[$locale] = $translation;
        }


        //get all settings and loop them
        foreach (Setting::all()->keyBy('field') as $item) {
            $parted = explode('.', $item->field);

            //check if the field is translated
            //if yes add it to translation classes
            if (count($parted) == 2 && in_array($parted[0], LaravelLocalization::getSupportedLanguagesKeys())) {
                $translations[$parted[0]]->setAttribute($parted[1], $item->value);
            }

            //add the field to mocked settings model
            $eloquent->setAttribute($item->field, $item->value);
        }

        //add the relation translations with all of the mocked translation models
        $eloquent->setRelation('translations', collect(array_values($translations)));

        return $eloquent;
    }


    public function registerMediaConversions(Media $media = null)
    {

        foreach (config('administration.settings_images') as $key => $sizes) {
            $this->addMediaConversion($key)
                ->width($sizes['width'])
                ->height($sizes['height'])
                ->sharpen(10)
                ->nonOptimized();
        }
    }
}
