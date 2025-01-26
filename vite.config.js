import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fs from 'fs'; // Импортируем модуль fs для работы с файловой системой
import path from 'path'; // Импортируем модуль path для работы с путями

export default defineConfig({
    server: {
        host: '0.0.0.0',  // Разрешить доступ с других устройств
        port: 5173,       // Порт, на котором работает Vite
        strictPort: true, // Запретить автоматический выбор порта
        hmr: {
            protocol: 'wss', // Используйте WebSocket Secure (WSS) для HTTPS
            host: 'family.tee.su',
        },
        https: {
            key: fs.readFileSync(path.resolve('/home/itee/conf/web/family.tee.su/ssl/family.tee.su.key')), // Приватный ключ
            cert: fs.readFileSync(path.resolve('/home/itee/conf/web/family.tee.su/ssl/family.tee.su.pem')), // Сертификат
        },
        cors: {
            origin: '*', // Разрешить запросы с любого домена
            methods: 'GET,HEAD,PUT,PATCH,POST,DELETE', // Разрешенные методы
            credentials: true, // Разрешить передачу учетных данных (куки, заголовки авторизации)
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});