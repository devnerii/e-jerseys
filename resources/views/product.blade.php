@extends('index')
@section('content-1')
    <form action="{{ route('site.cart.add') }}" method="POST">
        @csrf
        <input hidden name="id" value="{{ $produto->id }}">
        <section class="grid grid-cols-12 gap-8">
            @php
             //   dd($produto);
                $thumbs = array_reverse($produto->images ?? []);
                $videos = array_reverse($produto->videos ?? []);
                $gifs = array_reverse($produto->gifs ?? []);
                $oferta = '';
               
                if ($produto->price_full != 0.0) {
                    $oferta = 'DE ' . round(100 - ($produto->price * 100) / $produto->price_full) . '%';
                }
            @endphp
            <div class="col-span-12 md:col-span-6" x-data="{ swiper: null, swiper2: null }">
                <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2"
                    x-init="swiper = new Swiper('.mySwiper', {
                        spaceBetween: 10,
                        slidesPerView: 4,
                        freeMode: true,
                        watchSlidesProgress: true,
                    });
                    swiper2 = new Swiper('.mySwiper2', {
                        spaceBetween: 10,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        thumbs: { swiper: swiper, },
                    })">
                    <div class="swiper-wrapper">
                        @foreach ($thumbs as $thumb)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $produto->name }}" class="w-full">
                            </div>
                        @endforeach
                        @foreach ($videos as $video)
                            <div class="swiper-slide">
                                <video controls class="w-full">
                                    <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                                    Seu navegador não suporta o elemento de vídeo.
                                </video>
                            </div>
                        @endforeach
                        @foreach ($gifs as $gif)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $gif) }}" alt="{{ $produto->name }}" class="w-full">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div thumbsSlider="" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($thumbs as $thumb)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $thumb) }}" alt="{{ $produto->name }}" class="w-full">
                            </div>
                        @endforeach
                        @foreach ($videos as $video)
                            <div class="swiper-slide">
                                <video controls class="w-full">
                                    <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                                    Seu navegador não suporta o elemento de vídeo.
                                </video>
                            </div>
                        @endforeach
                        @foreach ($gifs as $gif)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $gif) }}" alt="{{ $produto->name }}" class="w-full">
                            </div>
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-6">

                <div class="px-2 pt-4 text-lg font-medium text-center">
                    {{ $produto->name }}
                </div>
                <div class="px-2 py-4 text-lg font-bold text-left text-primary">
                    {{ formatCurrency($produto->price) }}
                    @if ($produto->price_full != null && $produto->price_full != 0)
                        <span class="text-sm font-normal text-gray-600 line-through">
                            {{ formatCurrency($produto->price_full) }}
                        </span>
                    @endif

                    @if ($produto->in_stock == 0)
                        <span class="px-1 ml-1 text-xs font-medium text-white bg-black rounded">ESGOTADO</span>
                    @elseif($produto->on_sale == 1)
                        <span class="px-1 ml-1 text-xs font-medium text-white rounded bg-amber-600">
                            <x-filament::icon icon="heroicon-c-tag" class="inline w-3 h-3" /> OFERTA
                            {{ $oferta }}</span>
                    @endif
                </div>

                <div class="px-2 pt-1 pb-4">

                    @foreach ($produto->variant_properties as $variant)
                        <div class="p-2 mt-2 font-medium">{{ $variant['name'] }}</div>
                        <div class="w-full place-items-center">
                            <div class="w-full p-1 mb-2">
                                <select name="variant[{{ $variant['name'] }}]"
                                    class="w-6/12 p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50">
                                    @foreach ($variant['values'] as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-3 py-4 text-center">


                    <button
                        class="w-full px-4 py-2 font-bold text-white rounded @if ($produto->in_stock == 0) bg-gray-400 hover:bg-gray-300 @else bg-primary hover:bg-primary-light @endif"
                        type="submit" @if ($produto->in_stock == 0) disabled @endif>
                        Add to cart
                    </button>

                    <div class="col-span-12 p-2 leading-9">
                        {!! $produto->description !!}
                    </div>
                </div>

                @if ($produto->properties)
                    <div class="px-3 py-4 text-center">
                        <table
                            class=" w-full font-medium text-white border border-separate rounded-md table-auto border-spacing-0.5 bg-primary-dark opacity-60 hover:opacity-80">
                            <tbody>
                                @foreach ($produto->properties as $name => $value)
                                    <tr>
                                        <td class="p-3">{{ $name }}</td>
                                        <td class="p-3 text-center rounded-md bg-primary-light text-primary-darker">
                                            {{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>


        </section>
    </form>

    <div class="mt-10">
        <h2 class="text-2xl font-bold">Reviews</h2>
    
        @auth
            <form action="{{ route('reviews.store', $produto->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="stars" class="block mb-2 text-lg">How many stars?</label>
                    <select name="stars" id="stars" class="p-2 border border-gray-300 rounded">
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="comment" class="block mb-2 text-lg">Comment</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full p-2 border border-gray-300 rounded"></textarea>
                </div>
                <button type="submit" class="px-4 py-2 font-bold text-black bg-blue-500 rounded hover:bg-blue-700">
                    Submit Review
                </button>
            </form>
        @else
            <p class="mt-4">You need to be logged in to leave a review. <a href="{{ route('login') }}" class="text-blue-500 underline">Log in here</a>.</p>
        @endauth
    
        <div class="mt-8">
            @forelse($produto->reviews as $review)
                <div class="p-4 mb-4 border border-gray-300 rounded">
                    <h3 class="font-semibold">{{ $review->user->nickname ?? $review->user->name }}</h3>
                    <div class="flex items-center">
                        <span class="mr-2">{{ $review->stars }} stars</span>
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <x-filament::icon icon="heroicon-s-star"
                                    class="w-5 h-5 {{ $i <= $review->stars ? 'text-yellow-500' : 'text-gray-300' }}" />
                            @endfor
                        </div>
                    </div>
                    <p class="mt-2">{{ $review->comment }}</p>
                    <p class="text-sm text-gray-500">Submitted on {{ $review->created_at->format('d/m/Y') }}</p>
                </div>
            @empty
                <p class="mt-4">No reviews have been left for this product yet.</p>
            @endforelse
        </div>
    </div>
    
@endsection
