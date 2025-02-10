import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/site.css',
                'resources/js/site.js',
                'vendor/mkocansey/bladewind/public/css/animate.min.css',
                'vendor/mkocansey/bladewind/public/css/bladewind-ui.min.css',
                'vendor/mkocansey/bladewind/public/js/helpers.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        // Добавляем настройки сборки
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: undefined,
                entryFileNames: 'assets/[name].[hash].js',
                chunkFileNames: 'assets/[name].[hash].js',
                assetFileNames: 'assets/[name].[hash].[ext]'
            }
        }
    },
    server: {
        // Настройки dev сервера
        hmr: {
            host: 'localhost'
        },
        watch: {
            usePolling: true
        }
    },
    resolve: {
        // Настройки алиасов и разрешения путей
        alias: {
            '@': '/resources/js'
        }
    },
    optimizeDeps: {
        include: ['bladewind-ui'] // Включаем зависимости, которые нужно предварительно собрать
    }
});