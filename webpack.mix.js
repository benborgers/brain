const mix = require('laravel-mix');

mix.disableNotifications()

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer')
    ])
    .webpackConfig(require('./webpack.config'));
