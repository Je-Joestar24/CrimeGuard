const mix = require("laravel-mix");
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]).webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js')
        }
    }
});