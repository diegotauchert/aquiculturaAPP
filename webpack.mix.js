const mix = require("laravel-mix");

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

mix.copy("node_modules/tinymce/skins/", "public/js/skins/");
mix.copy("node_modules/tinymce/icons/default/", "public/js/icons/default/");
mix.copy("resources/icons/*", "public/icons/");
mix.copy("resources/fonts/*", "public/fonts/");
mix.copy("resources/fonts/exo/*", "public/fonts/exo/");
mix.copy("resources/fonts/raleway/*", "public/fonts/raleway/");
mix.copy("resources/fonts/Brandon/*", "public/fonts/Brandon/");
mix.copy("resources/fonts/Montserrat/*", "public/fonts/Montserrat/");
mix.copy("resources/images/*", "public/images/");
mix.copy("resources/assets/*", "public/assets/");

mix.copy("resources/js/js/*", "public/js/js/");

mix.sass("resources/sass/gestor.scss", "public/css");
mix.sass("resources/sass/login.scss", "public/css");
mix.sass("resources/sass/embreve.scss", "public/css");
mix.sass("resources/sass/web.scss", "public/css");

if (mix.inProduction()) {
    mix.js("resources/js/embreve.js", "public/js");
    mix.js("resources/js/gestor.js", "public/js");
    mix.js("resources/js/web.js", "public/js");
    mix.js("resources/js/dashboard.init.js", "public/js");
    mix.js("resources/js/app.js", "public/js");

    mix.version();
} else {
    mix.js("resources/js/gestor.js", "public/js").sourceMaps();
    mix.js("resources/js/embreve.js", "public/js").sourceMaps();
    mix.js("resources/js/web.js", "public/js").sourceMaps();
    mix.js("resources/js/dashboard.init.js", "public/js").sourceMaps();
    mix.js("resources/js/app.js", "public/js").sourceMaps();
}
