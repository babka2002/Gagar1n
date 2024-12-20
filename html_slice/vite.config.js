import { defineConfig } from 'vite';
import nunjucks from 'vite-plugin-nunjucks'
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        nunjucks()
    ],
    root: resolve(__dirname, '.'),
    build: {
        outDir: './dist',
        emptyOutDir: true,
        rollupOptions: {
        input: {
            main: resolve(__dirname, 'index.html'),
            pool: resolve(__dirname, 'pool.html'),
            trainers: resolve(__dirname, 'trainers.html'),
            trainersingle: resolve(__dirname, 'trainer_single.html'),
            cicle: resolve(__dirname, 'cicle.html')
        }
    }
  }
});

