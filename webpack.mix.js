let mix = require('laravel-mix');
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

   // App
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   // Bootstrap
   .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css')
   .js('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js')
   // My Styles
   .sass('resources/assets/sass/style.scss', 'public/css')
   .sass('resources/assets/sass/admin.scss', 'public/css')
   // Font Awesome
   .sass('node_modules/font-awesome/scss/font-awesome.scss', 'public/css')
   .copy('node_modules/font-awesome/fonts', 'public/fonts');
