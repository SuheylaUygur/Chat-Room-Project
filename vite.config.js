import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/login.css',
                'resources/css/profile.css',
                'resources/css/home.css',
                'resources/css/chat.css',
                'resources/css/alert.css',
                'resources/css/header.css',
                'resources/css/table.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
