<?php

namespace Charlotte\Administration\Helpers;


class AdministrationField
{

    public static function link($link, $attr = array())
    {
        if (empty($attr['icon'])) {
            $attr['icon'] = 'fa-external-link';
        }
        return view('administration::components.buttons.link', compact('link', 'attr'))->render();
    }

    public static function edit($link, $attr = array())
    {
        if (empty($attr['icon'])) {
            $attr['icon'] = 'ti-pencil';
        }

        if (empty($attr['color'])) {
            $attr['color'] = 'text-info';
        }

        return view('administration::components.buttons.link', compact('link', 'attr'))->render();
    }

    public static function delete($link, $attr = array())
    {
        if (empty($attr['icon'])) {
            $attr['icon'] = 'ti-trash';
        }

        if (empty($attr['color'])) {
            $attr['color'] = 'text-danger';
        }

        return view('administration::components.buttons.delete', compact('link', 'attr'))->render();

    }

    public static function restore($link, $attr = array())
    {
        if (empty($attr['icon'])) {
            $attr['icon'] = 'fa-undo';
        }

        if (empty($attr['color'])) {
            $attr['color'] = 'text-warning';
        }

        return view('administration::components.buttons.restore', compact('link', 'attr'))->render();
    }


    public static function media($model, $collections = ['default'])
    {
        return view('administration::components.buttons.media', compact('model', 'collections'))->render();
    }

    public static function switch($field, $model)
    {
        return view('administration::components.buttons.switch', compact('field', 'model'))->render();

    }

}