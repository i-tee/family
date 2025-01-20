import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'resources/views/**', // Отслеживать только изменения в Blade-шаблонах
                'resources/css/**',   // Отслеживать только изменения в CSS
                'resources/js/**',    // Отслеживать только изменения в JS
            ],
        }),
    ],
});

