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

mix.setPublicPath(path.normalize('public'))
   .options({
      processCssUrls: true
   }).styles([
   'resources/assets/css/bootstrap.min.css',
   'resources/assets/css/metismenu.min.css',
   'resources/assets/css/icons.css',
   'resources/assets/css/style.css'
], 'public/assets/css/plantilla.css')
   .scripts([
      'resources/assets/js/jquery.min.js',
      'resources/assets/js/bootstrap.bundle.min.js',
      'resources/assets/js/jquery.slimscroll.js',
      'resources/assets/js/waves.min.js',
      'resources/assets/js/app.js',
   ], 'public/js/plantillahead.js')
   .scripts([
      'resources/assets/js/jquery.min.js',
      'resources/assets/js/bootstrap.bundle.min.js',
      'resources/assets/js/jquery.slimscroll.js',
      'resources/assets/js/app.js',
   ], 'public/js/plantilla.js')

   .js(['resources/js/app.js'], 'public/js/app.js');
