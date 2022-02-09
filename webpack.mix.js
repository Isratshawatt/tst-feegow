const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]
);

mix
    .copy('resources/css/bootstrap.min.css', 'public/css/template.min.css')
    .copy('resources/css/select2.min.css', 'public/css/select2.min.css')
    .copy('resources/css/select2-bootstrap.min.css', 'public/css/select2-bootstrap.min.css')
    .postCss('resources/css/custom.css', 'public/css/custom.min.css')
    .scripts([
        'resources/js/bootstrap.bundle.min.js',
        'resources/js/jquery-3.6.0.min.js'
    ], 'public/js/template.min.js')
    .copy('resources/js/select2.min.js', 'public/js/select2.min.js')
    .copy('resources/js/sweetalert2.all.min.js', 'public/js/sweetalert2.all.min.js')
    .scripts('resources/js/jquery.mask.js', 'public/js/jquery.mask.min.js')
.version();
