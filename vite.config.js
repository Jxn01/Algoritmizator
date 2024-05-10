import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true
        })
    ],
    server: {
        strictPort: true,
        port: 5173,
        cors: true,
        proxy: {
            '/api': 'http://localhost:8000',
            '/sanctum/csrf-cookie': 'http://localhost:8000',
        }
    },
    build: {
        outDir: '/srv/http/algoritmizator',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: 'resources/js/app.jsx'
        }
    }
});
