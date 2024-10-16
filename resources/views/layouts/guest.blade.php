<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">
    @include('vendor.seo.seo')
    @livewireStyles
    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <div class="w-full h-screen py-16 bg-white">
        <div class="flex items-center justify-center">
            <a href="{{ route('site.home') }}">
                <img src="{{ asset('storage/' . $settings?->site_logo) }}" alt="{{ $settings?->site_name }}"
                    class="h-12" />
            </a>
        </div>

        <div class="flex items-center justify-center">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
    @vite('resources/js/app.js')
</body>

</html>
