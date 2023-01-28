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
const path = require('path');
mix.webpackConfig({
    resolve: {
        alias: {
            "@": path.resolve("./resources"),
        },
    },
});

mix .js('resources/js/user.js', 'public/js')
    .vue()
    .sass('resources/sass/user.scss', 'public/css');