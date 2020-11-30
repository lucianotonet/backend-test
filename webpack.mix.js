const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

// Backstage
mix.js('resources/js/backstage.js', 'public/js')
    .sass('resources/sass/backstage.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .version();

// Frontend
mix.js('resources/js/frontend.js', 'public/js')
    .sass('resources/sass/frontend.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .version();

// Errors
mix.sass('resources/sass/errors.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .version();
