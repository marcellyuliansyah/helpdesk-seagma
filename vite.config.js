import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0",
        hmr: {
<<<<<<< HEAD
            host: '192.168.7.176' // Menggunakan IP laptop Anda

        }
    }
});
=======
            host: "192.168.7.176",
        },
    },
});
>>>>>>> 519ca638be491006f8b2055ae28ff6ce20c0f695
