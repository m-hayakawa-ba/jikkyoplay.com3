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
        extensions: ['.js', '.ts'],
        alias: {
            "@": path.resolve("./resources"),
        },
    },
});

mix .ts('resources/js/user.ts', 'public/js')
    .vue()
    .sass('resources/sass/user.scss', 'public/css');