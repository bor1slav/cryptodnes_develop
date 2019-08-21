<?php


return [
    /*
     * Package version
     */
    'package_version' => '1.0.0',
    /*
     * URL Prefix
     */
    'url_prefix' => 'admin',

    /*
    * Views Prefix
    */
    'views_prefix' => 'administration',
    'admin_prefix' => 'administration',


    /*
     * Administrator guard name
     */
    'guard' => 'administrator',

    'file_prefix' => 'charlotte/administration/',

    /*
     * Supported Languages
     */
    'admin_supported_locales' => [
        'en',
        'bg'
    ],

    /*
   * Settings Images Conversions
   */
    'settings_images' => [
        'thumb' => [
            'width' => 100,
            'height' => 100,
        ],
        'long_ad' => [
            'width' => 120,
            'height' => 595,
        ]
    ],

    //Default fields for settings
    'settings_default_fields' => [
        'website_title' => [
            'title' => 'administration::admin.website_name',  //this will be converted to trans
            'type' => 'text'
        ],
        'facebook' => [
            'title' => 'index::admin.facebook',  //this will be converted to trans
            'type' => 'text'
        ],
        'telegram' => [
            'title' => 'index::admin.telegram',  //this will be converted to trans
            'type' => 'text'
        ],
        'twitter' => [
            'title' => 'index::admin.twitter',  //this will be converted to trans
            'type' => 'text'
        ],
        'instagram' => [
            'title' => 'index::admin.instagram',  //this will be converted to trans
            'type' => 'text'
        ]
    ]

];
