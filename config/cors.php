<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Разрешить только API и CSRF-запросы
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], // Разрешенные HTTP-методы
    'allowed_origins' => ['https://family.tee.su:5173', 'https://family.tee.su'], // Разрешенные домены
    'allowed_origins_patterns' => [], // Паттерны для разрешенных доменов (не используется)
    'allowed_headers' => ['Authorization', 'Content-Type', 'X-Requested-With'], // Разрешенные заголовки
    'exposed_headers' => [], // Заголовки, доступные клиенту (пусто, если не нужно)
    'max_age' => 0, // Время кэширования CORS-предзапроса (0 = отключено)
    'supports_credentials' => true, // Разрешить передачу учетных данных (куки, заголовки авторизации)
];