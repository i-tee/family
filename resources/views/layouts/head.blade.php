<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- ViteStart -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- ViteEnd -->

</head>