<section class="w-full">
    <div x-data="{ swiper: null }" x-init="swiper = new Swiper($refs.container, {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    })" class="relative flex flex-row w-full">
        <div class="absolute inset-y-0 z-10 flex items-center left-5">
            <button @click="swiper.slidePrev()"
                class="flex items-center justify-center w-8 h-8 -ml-2 rounded-full shadow bg-gray-50/50 lg:-ml-4 focus:outline-none">
                <x-filament::icon icon="heroicon-s-chevron-left" class="w-5 h-5 " />
            </button>
        </div>

        <div class="w-full overflow-hidden swiper-container" x-ref="container">
            <div class="swiper-wrapper">

                @foreach ($banners as $banner)
                    @if (!$banner['mid_page_banner']) 
                        <div class="swiper-slide">
                            <div class="flex flex-col overflow-hidden shadow">
                                <div class="flex-shrink-0">
                                    @if ($banner['link_type'] !== 'none')
                                        <a href="{{ $banner['link'] }}"
                                            @if ($banner['link_type'] == 'external') target="_blank" rel="noreferrer nofollow" @endif>
                                    @endif
                                    
                                    @if ($banner['video_path'])
                                        <video class="object-cover w-full" autoplay muted loop>
                                            <source src="{{ asset('storage/' . $banner['video_path']) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <picture>
                                            <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $banner['image_sm']) }}">
                                            <img class="object-cover w-full" src="{{ asset('storage/' . $banner['image_lg']) }}" alt="">
                                        </picture>
                                    @endif
                                    
                                    @if ($banner['link_type'] !== 'none')
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="swiper-pagination"></div>

        <div class="absolute inset-y-0 z-10 flex items-center right-5">
            <button @click="swiper.slideNext()"
                class="flex items-center justify-center w-8 h-8 -mr-2 rounded-full shadow bg-gray-50/50 lg:-mr-4 focus:outline-none">
                <x-filament::icon icon="heroicon-s-chevron-right" class="w-5 h-5 " />
            </button>
        </div>
    </div>
</section>
