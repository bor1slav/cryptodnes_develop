<?php

namespace Charlotte\Administration\Helpers;


class AdministrationSeo {


    public static function seoFields($form, $attr = [], $translate = true, $fields = []) {


        if (empty($fields)) {
            $fields = ['slug', 'meta_title', 'meta_description', 'meta_keywords'];
        }

        foreach ($fields as $field) {

            $form->add($field, 'text', [
                'title' => trans('administration::admin.' . $field),
                'translate' => $translate,
                'attr' => (!empty($attr[$field])) ? $attr[$field] : [],
            ]);
        }

        return $form;

    }
}