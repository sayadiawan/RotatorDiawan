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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
//js
mix.scripts([
        'public/vendors/js/vendor.bundle.addons.js',
        'public/js/off-canvas.js',
        'public/js/hoverable-collapse.js',
        'public/js/misc.js',
        'public/js/settings.js',
        'public/js/dashboard.js',
        'public/js/formpickers.js',
        'public/js/form-addons.js',
        'public/js/form-repeater.js',
        'public/js/smt-library.js',
        'public/js/form-validation.js',
        'public/js/file-upload.js',
        'public/js/typeahead.js',
        'public/js/select2.js',
        'public/js/dropify.js',
        'public/js/dropzone.js',
        'public/js/sweetalert.min.js',
        'public/js/tablesorter.js',
        'public/js/jq.tablesort.js',
        'public/js/dataTables.responsive.min.js',
        'public/js/responsive.bootstrap4.min.js',
    ],
    'public/js/result_combine.js').version();
//css
mix.styles([
        'public/vendors/css/vendor.bundle.base.css',
        'public/vendors/css/vendor.bundle.addons.css',
        'public/css/style.css',
        'public/css/custom.css',
        'public/css/responsive.bootstrap4.min.css',
    ],
    'public/css/result_combine.css').version();