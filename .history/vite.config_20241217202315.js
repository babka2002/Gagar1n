import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import vue2 from '@vitejs/plugin-vue2';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/site.css',
                'resources/js/site.js',

                'vendor/mkocansey/bladewind/public/css/animate.min.css',
                'vendor/mkocansey/bladewind/public/css/bladewind-ui.min.css',
                'vendor/mkocansey/bladewind/public/js/helpers.js'
                // Control Panel assets.
                // https://statamic.dev/extending/control-panel#adding-css-and-js-assets
                // 'resources/css/cp.css',
                // 'resources/js/cp.js',
            ],
            refresh: true,
        }),
        // vue2(),
    ],
});
