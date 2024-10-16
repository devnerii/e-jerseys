@extends('index')
@section('content-1')
    <h1 class="mb-8 text-xl font-bold text-center">All products</h1>
    <section>
        <form action="{{ route('site.products', ['homePageSlug'=> $homePage->slug, 'slug' => $slug]) }}" method="GET" class="flex justify-between gap-2 my-4 text-sm"
            x-data="{ category: '' }">
            @csrf
            <label for="category">Filter:
                <select name="category" id="category" class="bg-white rounded-sm"
                    x-on:input.change="console.log($event.target.form.submit())">
                    <option value="">Categories</option>
                    @foreach ($categorias as $category)
                        <option value="{{ $category->slug }}" @if ($category->slug == $categoria?->slug) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </label>
            <select name="sort_by" id="sort_by" class="bg-white rounded-sm"
                x-on:input.change="console.log($event.target.form.submit())">
                <option value="">Order</option>
                <option value="name_asc" @if ($sort_by == 'name_asc') selected @endif>Alphabetical order A-Z</option>
                <option value="name_desc" @if ($sort_by == 'name_desc') selected @endif>Alphabetical order Z-A</option>
                <option value="price_asc" @if ($sort_by == 'price_asc') selected @endif>Price ascending</option>
                <option value="price_desc" @if ($sort_by == 'price_desc') selected @endif>Price descending</option>
            </select>
        </form>
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
            @foreach ($produtos as $produto)
                @php
                    $oferta = '';
                    if ($produto->price_full != 0.0) {
                        $oferta = 'DE ' . round(100 - ($produto->price * 100) / $produto->price_full) . '%';
                    }
                @endphp
                <a href="{{ route('site.product', ['homePageSlug' => $homePage->slug, 'slug'=> $produto['slug']]) }}">
                    <div class="product col-span-1 bg-white shadow-lg shadow-slate-100 rounded-xl">
                        <div class="relative overflow-hidden">
                            @if (!empty($produto->images) && count($produto->images) > 0)
                            <img src="{{ asset('storage/' . array_reverse($produto->images)[0]) }}"
                                alt="{{ $produto->name }}" class="w-full transition-transform rounded-t-xl hover:scale-105">
                            @endif    
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
                        <div class="title px-2 pt-4 text-lg font-medium text-center">
                            {{ $produto->name }}
                        </div>
                        <div class="px-2 py-4 text-lg font-bold text-center text-primary">
                            {{ formatCurrency($produto->price) }}
                            @if ($produto->price_full != null && $produto->price_full != 0)
                                <span class="text-sm font-normal text-gray-600 line-through">
                                    {{ formatCurrency($produto->price_full) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8 mb-16 text-center">
            {{ $produtos->links('vendor.pagination.tailwind') }}
        </div>
    </section>
@endsection
