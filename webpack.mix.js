const mix = require('laravel-mix');

const Dotenv = require('dotenv-webpack');

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

mix.disableSuccessNotifications();

mix.js('resources/js/app.js', 'public/js').vue();

mix.postCss('resources/css/app.css', 'public/css');
mix.postCss('resources/css/print.css', 'public/css');

mix.webpackConfig({
  plugins: [
    new Dotenv({
      expand: true,
    }),
  ],
});

mix.extract();

if (mix.inProduction()) {
  mix.version();
} else {
  mix.sourceMaps();
  mix.browserSync({
    proxy: {
      target: 'localhost:80',
      ws: true,
    },
    open: false,
    tunnel: false,
  });
}
