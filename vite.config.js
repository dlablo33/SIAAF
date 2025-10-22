import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    server: {
        cors: true,
        origin: 'http://localhost:5173'
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // Componentes de Vue
                'resources/js/rh/nomina/nomina.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
    alias: {
      'vue': 'vue/dist/vue.esm-bundler.js',
    }
  }
});
