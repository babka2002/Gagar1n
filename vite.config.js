import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/site.css',
		'resources/css/markdown-content.css',
                'resources/js/site.js',
                'vendor/mkocansey/bladewind/public/css/animate.min.css',
                'vendor/mkocansey/bladewind/public/css/bladewind-ui.min.css',
                'vendor/mkocansey/bladewind/public/js/helpers.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: 'manifest.json', // Изменено здесь
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: undefined,
                entryFileNames: 'assets/[name].[hash].js',
                chunkFileNames: 'assets/[name].[hash].js',
                assetFileNames: 'assets/[name].[hash].[ext]'
            }
        }
    }
});