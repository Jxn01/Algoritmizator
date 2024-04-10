const mix = require('laravel-mix');
require('laravel-mix-postcss');

mix.postCss('resources/css/app.css', 'public/css', [
    require('tailwindcss'),
]);

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.react('resources/js/app.js', 'public/js');

