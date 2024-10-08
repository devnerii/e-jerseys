<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">
    @include('vendor.seo.seo')
    @livewireStyles
    @vite('resources/css/app.css')
</head>

<body class="antialiased" x-data="{
    cart: {{ json_encode(session()->get('cart', [])) }},
    cartTotal: {{ json_encode(session()->get('cart-total', 0.0)) }},
    cartShow: {{ json_encode(session()->get('showCartAdd', false)) }},
    cartOpen: false,
    loading: true,
    toggleCartOpen() {
        this.cartOpen = !this.cartOpen;
    },
    showCartOpen() {
        this.cartOpen = true;
    }
}">
    <header class="w-full p-0">
        @include('menu')
    </header>
    @yield('banner')
    @yield('banner2')


    <!-- Page Content -->
    <main class="w-full py-16 bg-slate-50">
        <div class="px-2 mx-auto max-w-7xl md:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    @include('footer')
    @include('cart')
    @livewireScripts
    @vite('resources/js/app.js')
    @yield('scripts')
</body>

</html>
