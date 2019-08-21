const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js/app.js');


mix.styles([
    'resources/css/owl.carousel.min.css',
    'resources/css/owl.theme.default.min.css',
], 'public/css/all.css');

mix.sass('resources/scss/app.scss', 'public/css/app.css');
mix.less('resources/less/dark-style.less', 'public/css/dark-style.css').options({
    processCssUrls: false
});
mix.less('resources/less/style.less', 'public/css/style.css').options({
    processCssUrls: false
});

mix.copy('resources/images/', 'public/images/');
mix.copy('resources/js/jquery.dataTables.js', 'public/js/jquery.dataTables.js');
mix.copy('resources/js/dataTables.fixedHeader.js', 'public/js/dataTables.fixedHeader.js');
mix.copy('resources/css/fixedHeader.dataTables.css', 'public/css/fixedHeader.dataTables.css');
mix.copy('resources/css/jquery.dataTables.css', 'public/css/jquery.dataTables.css');


mix.copyDirectory('resources/images', 'public/images');