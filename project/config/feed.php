<?php

return [
    'feeds' => [
        'news' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * '\App\Model@getAllFeedItems'
             */
            'items' => 'App\Modules\Blog\Models\Blog@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed/news',

            'title' => 'All blog articles from www.cryptodnes.bg',

            /*
             * Custom view for the items.
             *
             * Defaults to feed::feed if not present.
             */
            'view' => 'feed::feed',
        ],
        'analyzes' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * '\App\Model@getAllFeedItems'
             */
            'items' => 'App\Modules\Analyzes\Models\Analyze@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed/analyzes',

            'title' => 'All analyzes from www.cryptodnes.bg',

            /*
             * Custom view for the items.
             *
             * Defaults to feed::feed if not present.
             */
            'view' => 'feed::feed',
        ],
    ],
];
