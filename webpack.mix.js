const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .copy('node_modules/trumbowyg/dist/ui/trumbowyg.min.css', 'public/css')
    .copy('node_modules/trumbowyg/dist/trumbowyg.min.js', 'public/js')
    .copy('node_modules/trumbowyg/dist/ui/icons.svg', 'public/js/icons.svg') // Đường dẫn sửa đổi
// .copy('node_modules/trumbowyg-table-plugin/dist/trumbowyg.table.min.js', 'public/js')
// .copy('node_modules/trumbowyg-table-plugin/dist/ui/trumbowyg.table.min.css', 'public/css');