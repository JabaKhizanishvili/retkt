<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia

    <script>
        window.translations = {
            'auth.login': '{{ __('auth.login') }}',
            'forget_password': '{{ __('auth.forget_password') }}',
            'auth.register': '{{ __('auth.register') }}',
            'dashboard': '{{ __('translations.dashboard') }}',
            'home': '{{ __('translations.home') }}',
            'about': '{{ __('translations.about') }}',
            'contact': '{{ __('translations.contact') }}',
            'events': '{{ __('translations.events') }}',
        };
    </script>
</body>

</html>
