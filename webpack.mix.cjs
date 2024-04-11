const mix = require('laravel-mix')
require('laravel-mix-postcss');

mix.js('resources/js/app.js', 'public/js')
    .react()
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
]);


