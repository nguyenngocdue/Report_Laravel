const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/css/app.scss', 'public/css')
    // Thêm tác vụ copyDirectory vào Laravel Mix để sao chép TinyMCE
    .copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce');

const posthtml = require('posthtml');
const posthtmlCssToTailwind = require('posthtml-css-to-tailwindcss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.blade\.php$/,
                    use: [
                        {
                            loader: 'posthtml-loader',
                            options: {
                                plugins: [
                                    posthtmlCssToTailwind(),
                                ],
                            },
                        },
                    ],
                },
            ],
        },
    });