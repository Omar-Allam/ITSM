const { mix } = require('laravel-mix');

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
 //
 mix.sass('resources/assets/sass/app.scss', 'public/css');
 //     .js('resources/assets/js/app.js', 'public/js')
 //     .js('resources/assets/js/Report/index.js', 'public/js/report.js')
 //     .js('resources/assets/js/ticket-index.js', 'public/js')
 //     .js('resources/assets/js/ticket-form.js', 'public/js')
 //     .js('resources/assets/js/ticket.js', 'public/js')
 //     .js('resources/assets/js/criteria.js', 'public/js')
 //     .js('resources/assets/js/business-rules.js', 'public/js')
 //     .js('resources/assets/js/task.js', 'public/js')
 //     .js('resources/assets/js/escalation.js', 'public/js');

 mix.js('resources/assets/js/ticket-note.js', 'public/js');
