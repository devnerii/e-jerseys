@extends('index')
@section('banner')
    @include('banner')
@endsection

@section('mid-banner')
    @include('mid-banner')
@endsection

@section('content-1')

    <h1 class="mb-8 text-xl font-bold text-center">Main products!</h1>
    <section>
        <section>
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 mb-16">
                @foreach ($produtos_principais as $produto)
                    @php
                        $oferta = '';
                        if ($produto->price_full != 0.0) {
                            $oferta = 'DE ' . round(100 - ($produto->price * 100) / $produto->price_full) . '%';
                        }
                    @endphp
                    <a href="{{ route('site.product', $produto['slug']) }}">
                        <div class="col-span-1 bg-white shadow-lg shadow-slate-100 rounded-xl">
                            <div class="relative overflow-hidden">
                                @if (!empty($produto->images) && count($produto->images) > 0)
                                    <img src="{{ asset('storage/' . array_reverse($produto->images)[0]) }}" alt="{{ $produto->name }}"
                                        class="w-full transition-transform rounded-t-xl hover:scale-105">
                                @endif
                                @if ($produto->in_stock == 0)
                                    <span class="absolute py-0.5 px-1 text-xs font-medium text-white bg-black rounded left-3 bottom-3">ESGOTADO</span>
                                @elseif($produto->on_sale == 1)
                                    <span class="absolute py-0.5 px-1 text-xs font-medium text-white bg-amber-600 rounded left-3 bottom-3">
                                        <x-filament::icon icon="heroicon-c-tag" class="inline w-3 h-3" /> OFERTA
                                        {{ $oferta }}</span>
                                @endif
                            </div>
                            <div class="px-2 pt-4 text-lg font-medium text-center truncate-container">
                                <div class="truncate">
                                    {{ $produto->name }}
                                </div>
                            </div>
                            <div class="px-2 py-4 text-lg font-bold text-center text-primary">
                                R$ {{ $produto->price }}
                                @if ($produto->price_full != null && $produto->price_full != 0)
                                    <span class="text-sm font-normal text-gray-600 line-through">R$ {{ $produto->price_full }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        
            <div class="text-center move-down" x-data="{ hover: false }">
                <a href="{{ route('site.products', ['slug' => $slug]) }}" x-on:mouseover="hover = true" x-on:mouseleave="hover = false"
                    x-bind:class="{ 'pr-10': hover, 'pr-4': !hover }"
                    class="relative inline-block py-2 pl-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                    See all
                    <x-filament::icon icon="heroicon-c-arrow-right" class="absolute transition-all w-5 h-5 right-3 top-2.5"
                        x-bind:class="{ 'translate-x-0': hover, 'translate-x-8': !hover }" />
                </a>
            </div>
        </section>

    </section>
@endsection

@section('content-2')
    <h1 class="my-8 text-xl font-bold text-center">Featured products!</h1>
    <section>
        <div class="grid grid-cols-2 gap-8">
            @foreach ($produtos_destaques as $produto)
                @php
                    $oferta = '';
                    if ($produto->price_full != 0.0) {
                        $oferta = 'DE ' . round(100 - ($produto->price * 100) / $produto->price_full) . '%';
                    }
                @endphp
                <a href="{{ route('site.product', $produto['slug']) }}">
                    <div class="col-span-1 bg-white shadow-lg shadow-slate-100 rounded-xl">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . array_reverse($produto->images)[0]) }}"
                                alt="{{ $produto->name }}"
                                class="w-full transition-transform rounded-t-xl hover:scale-105">
                            @if ($produto->in_stock == 0)
                                <span
                                    class="absolute py-0.5 px-1 text-xs font-medium text-white bg-black rounded left-3 bottom-3">ESGOTADO</span>
                            @elseif($produto->on_sale == 1)
                                <span
                                    class="absolute py-0.5 px-1 text-xs font-medium text-white bg-amber-600 rounded left-3 bottom-3">
                                    <x-filament::icon icon="heroicon-c-tag" class="inline w-3 h-3" /> OFERTA
                                    {{ $oferta }}</span>
                            @endif
                        </div>
                        <div class="px-2 pt-4 text-lg font-medium text-center">
                            {{ $produto->name }}
                        </div>
                        <div class="px-2 py-4 text-lg font-bold text-center text-primary">
                            R$ {{ $produto->price }}
                            @if ($produto->price_full != null && $produto->price_full != 0)
                                <span class="text-sm font-normal text-gray-600 line-through">R$
                                    {{ $produto->price_full }}
                                </span>
                            @endif

                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="text-center move-down" x-data="{ hover: false }">
            <a href="{{ route('site.products', ['slug' => $slug]) }}" x-on:mouseover="hover = true" x-on:mouseleave="hover = false"
                x-bind:class="{ 'pr-10': hover, 'pr-4': !hover }"
                class="relative inline-block py-2 pl-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                See all
                <x-filament::icon icon="heroicon-c-arrow-right" class="absolute transition-all w-5 h-5 right-3 top-2.5"
                    x-bind:class="{ 'translate-x-0': hover, 'translate-x-8': !hover }" />
            </a>
        </div>
    </section>

  
    
@endsection
