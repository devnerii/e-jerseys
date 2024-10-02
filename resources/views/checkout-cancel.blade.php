<x-guest-layout>
    <div class="flex flex-col items-center justify-center w-full">
        <div class="mt-8 mb-4 text-xl font-medium text-gray-600">
            Compra cancelada!
        </div>
        <div class="flex justify-between mt-8 mb-16 text-sm" x-data="{ hover: false }">
            <a href="{{ route('site.home') }}" x-on:mouseover="hover=true" x-on:mouseleave="hover = false"
                x-bind:class="{ 'pl-10': hover, 'pl-4': !hover }"
                class="relative inline-block py-2 pr-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                Voltar a loja
                <x-filament::icon icon="heroicon-c-arrow-left" class="absolute transition-all w-5 h-5 left-3 top-2.5"
                    x-bind:class="{ 'translate-x-0': hover, '-translate-x-8': !hover }" />
            </a>
        </div>
    </div>
</x-guest-layout>
