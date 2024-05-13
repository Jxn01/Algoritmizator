import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import { resolve } from 'path';

export default defineConfig({
    base: '/algoritmizator/',
    plugins: [
        react(),
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true
        })
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'), // This uses the `resolve` function
        },
    },
    server: {
        strictPort: true,
        port: 5173,
        cors: true,
        proxy: {
            '/api': 'https://jxn.ddns.net/algoritmizator',
            '/sanctum/csrf-cookie': 'https://jxn.ddns.net/algoritmizator',
        }
    },
    build: {
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.jsx'), // Main JS
                style: resolve(__dirname, 'resources/css/app.css') // Main CSS
            }
        }
    }
});
