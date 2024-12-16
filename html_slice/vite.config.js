import nunjucks from 'vite-plugin-nunjucks'

export default {
    plugins: [
        nunjucks(),
    ]
}



// import { defineConfig } from 'vite'
// import { sync as globSync } from 'glob'
//
// const htmlFiles = globSync('**/*.html');
//
// export default defineConfig({
//   build: {
//     rollupOptions: {
//       input: htmlFiles
//     }
//   }
// })
