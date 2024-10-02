@php
    $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
    $menus = App\Models\Menu::where('is_active', true)->where('section', 'header')->get()->toArray();
    foreach ($menus as $key => $menu) {
        if ($menus[$key]['link_type'] == 'external' || $menus[$key]['link_type'] == 'none') {
            $menus[$key]['link'] = $menus[$key]['link_slug'];
        } else {
            $menus[$key]['link'] = route('site.' . $menus[$key]['link_type'], [
                'slug' => $menus[$key]['link_slug'],
            ]);
        }
    }
@endphp
@if ($settings != null)
    <section class="w-full p-3 font-medium text-center text-white bg-primary text-primary-lighter">
        {{ $settings['more_configs']['alert_text'] }}
    </section>
@endif
<nav class="relative py-8" x-data="{
    mobileMenuOpen: false,
    searchOpen: false,
    toggleMobileMenu() {
        this.mobileMenuOpen = !this.mobileMenuOpen;
    },
    toggleSearch() {
        this.searchOpen = !this.searchOpen;
    }
}">
    <div class="px-2 mx-auto max-w-7xl md:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center md:hidden">
                <!-- Mobile menu button-->
                <button type="button" class="relative inline-flex items-center justify-center p-2"
                    aria-controls="mobile-menu" aria-expanded="false" x-on:click="toggleMobileMenu()">
                    <span class="absolute -inset-0.5"></span>
                    <!--
                        Icon when menu is closed.

                        Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg x-bind:class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen, }" class="w-6 h-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!--
                        Icon when menu is open.

                        Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg x-bind:class="{ 'hidden': !mobileMenuOpen, 'block': mobileMenuOpen, }" class="w-6 h-6"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center flex-1 md:items-stretch md:justify-start">
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('custom.home', ['slug' => $homePage->slug]) }}">
                        <img src="{{ asset('storage/' . $homePage->logo_path) }}" alt="{{ $settings?->site_name }}"
                            class="h-12" />
                    </a>
                </div>
                <div class="hidden md:ml-6 md:block">
                    <div class="flex flex-wrap justify-start">
                        @foreach ($menus as $menu)
                            <a href="{{ $menu['link'] }}"
                                class="px-3 py-2 text-sm font-medium text-gray-800 transition-colors hover:text-primary"
                                @if ($menu['link_type'] == 'external') target="_blank" rel="noreferrer nofollow" @endif>{{ $menu['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 md:static md:inset-auto md:ml-6 md:pr-0">
                <button type="button" class="relative p-2 hover:scale-110" x-on:click="toggleSearch()">
                    <x-filament::icon icon="heroicon-o-magnifying-glass" class="w-6 h-6" />

                </button>

                <button type="button" class="relative p-2 hover:scale-110" x-on:click="cartOpen = !cartOpen">
                    <span
                        class="absolute @if (count(session()->get('cart', [])) == 0) hidden @endif w-4 h-4 text-xs font-medium text-center text-white align-middle rounded-full bg-primary-dark bottom-1">{{ count(session()->get('cart', [])) }}</span>
                    <x-filament::icon icon="heroicon-o-shopping-cart" class="w-6 h-6" />

                </button>



                <div class="relative" x-data="{ userMenuOpen: false }">
                    <div class="inline-flex items-baseline mt-2 overflow-hidden">
                        <a href="@if (Auth::check()) {{ '#' }} @else {{ route('login') }} @endif"
                            type="button" class="relative p-2 cursor-pointer hover:scale-110"
                            @if (Auth::check()) x-on:click="userMenuOpen = !userMenuOpen" @endif>
                            <x-filament::icon icon="heroicon-o-user" class="w-6 h-6" />
                        </a>
                    </div>

                    <div class="absolute z-10 hidden w-56 -mt-2 bg-white border border-gray-100 rounded-md shadow-lg end-0"
                        role="menu" x-bind:class="{ 'hidden': !userMenuOpen, 'block': userMenuOpen, }"
                        x-init="setTimeout(() => $el.classList.remove('hidden'), 100) >
                            <
                            div class ="p-2">
                        <a href="{{ isset($slug) ? route('profile.edit', ['slug' => $homePage->slug]) : route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            My data
                        </a>

                        <a href="{{ isset($slug) ? route('profile.orders', ['slug' => $homePage->slug]) : route('profile.orders') }}"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            My orders
                        </a>

                        <a href="{{ isset($slug) ? route('profile.address', ['slug' => $homePage->slug]) : route('profile.addres') }}"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                            role="menuitem">
                            My address
                        </a>


                        <form method="POST" action="{{ route('logout') }}"">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-sm text-left text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700"
                                role="menuitem">

                                Logout
                            </button>
                        </form>
                    </div>
                </div>


            </div>

        </div>

    </div>

    </div>


    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-bind:class="{ 'hidden': !mobileMenuOpen }" class="hidden md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @foreach ($menus as $menu)
                <a href="{{ $menu['link'] }}" class="block px-3 py-2 text-base font-medium"
                    @if ($menu['link_type'] == 'external') target="_blank" rel="noreferrer nofollow" @endif>{{ $menu['label'] }}</a>
            @endforeach
        </div>
    </div>
    <div class="absolute z-30 w-64 p-4 bg-slate-50 rounded-lg shadow-md top-full right-0 mt-1 search-bar" 
        x-bind:class="{ 'hidden': !searchOpen, 'block': searchOpen }">
        <form method="GET" action="{{ route('site.products', ['slug' => $slug]) }}">
            <input type="text" name="q" class="w-full p-2 border border-gray-300 rounded-xl" placeholder="Search...">
        </form>
    </div>


</nav>

<style>
    .search-bar {
        margin-right: 12rem; 
    }

    @media (max-width: 1200px) {
        .search-bar {
            margin-right: 2rem;
        }
    }
</style>
