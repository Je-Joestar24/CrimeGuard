const mix = require("laravel-mix");
const path = require('path');
mix.webpackConfig({
    devServer: {
        proxy: {
            '*': 'http://127.0.0.1:8000',  
        },
        port: 8080,  
        host: 'localhost',
        headers: {
            'Access-Control-Allow-Origin': '*',
        }
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/js')
        },
        fallback: {
            fs: false  // 👈 Add this to suppress the face-api.js warning
        }
    }
});
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