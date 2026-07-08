import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // Letakkan server sejajar dengan plugins, di dalam defineConfig
    server: {
        host: '0.0.0.0',
        hmr: {
<<<<<<< HEAD
            host: '192.168.7.176' // Menggunakan IP laptop Anda
=======
            host: '192.168.7.147' // Menggunakan IP laptop Anda
>>>>>>> 940423174aed46c8bd519e5cb0c9bb49263603a2
        }
    }
});