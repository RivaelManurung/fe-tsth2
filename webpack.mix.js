const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'resources/js')
   .vue()   // kalau kamu pakai Vue.js, kalau nggak bisa dihapus
   .postCss('resources/css/app.css', 'public/css', [
       //
   ]);

mix.sourceMaps();
