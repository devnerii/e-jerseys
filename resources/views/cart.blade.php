@php
    $showCartAdd = session()->get('showCartAdd', false);
@endphp
<aside
    class="cart fixed rounded-l-xl shadow-2xl top-0 right-0 z-30 flex flex-col @if (!$showCartAdd) hidden @endif h-full overflow-auto transition-transform duration-300 ease-in-out transform bg-white w-full md:w-96"
    x-bind:class="{ 'translate-x-0': cartOpen, 'translate-x-full': !cartOpen }" x-init="setTimeout(() => $el.classList.remove('hidden'), 100)">

    <div class="flex justify-between flex-shrink p-4" @if ($showCartAdd) x-init="showCartOpen()" @endif>
        <div class="text-lg font-medium">Cart</div>
        <button x-on:click="toggleCartOpen()"><x-filament::icon icon="heroicon-o-x-mark" class="w-6 h-6" /></button>
    </div>
    <div class="flex flex-col flex-grow gap-4 p-4 overflow-y-scroll">

        @php
            $cart = session()->get('cart', []);
            $cartTotal = session()->get('cart-total', 0.0);
        @endphp
        @forelse ($cart as $id => $product)
            @php
                $product['variant_str'] = '';
                $variants = $product['variant'];
                if ($variants !== null) {
                    $product['variant_str'] = [];
                    foreach ($variants as $key => $variant) {
                        $product['variant_str'][] = $key . ': ' . $variant;
                    }
                    $product['variant_str'] = implode(', ', $product['variant_str']);
                }
            @endphp
            <div class="grid w-full grid-cols-7 gap-4 p-2 rounded-xl">
                <div class="content-center col-span-2 row-span-2"><img src="{{ asset('storage/' . $product['image']) }}"
                        alt="" class="w-full"></div>
                <div class="col-span-3">
                    <div class="font-medium text-md"><a
                            href="{{ route('site.product', $product['slug']) }}">{{ $product['name'] }}</a></div>
                    <div class="text-xs font-medium">
                        {{ $product['variant_str'] }}
                    </div>

                </div>
                <div class="col-span-2 text-sm font-medium"><span class="text-xs">R$</span>
                    {{ $product['price'] * $product['quantity'] }}
                </div>
                <div class="flex items-center col-span-3 font-medium h-14 md:h-12 text-md">
                    <div
                        class="inline-flex items-center font-medium border border-gray-300 h-14 md:h-12 rounded-xl text-md">
                        <a href="{{ route('site.cart.minus', [$product['id'], $product['hash']]) }}"
                            class="inline-block p-3"><x-filament::icon icon="heroicon-o-minus" class="w-4 h-4" /></a>
                        <input type="number"
                            class="w-1 p-2 text-center bg-transparent border-0 md:w-12 focus:ring-transparent focus:outline-none  [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                            value="{{ $product['quantity'] }}" min="0" max="1000" />
                        <a href="{{ route('site.cart.plus', [$product['id'], $product['hash']]) }}"
                            class="inline-block p-3"><x-filament::icon icon="heroicon-o-plus" class="w-4 h-4" /></a>
                    </div>
                </div>
                <div class="flex items-center col-span-2 text-sm font-medium">
                    <a href="{{ route('site.cart.remove', [$product['id'], $product['hash']]) }}"><x-filament::icon
                            icon="heroicon-o-trash" class="w-4 h-4" /></a>
                </div>
            </div>
        @empty
            <div>Empty cart</div>
        @endforelse



    </div>
    <div class="flex-shrink w-full p-4 ">
        <div class="flex justify-between py-2 text-lg font-medium">
            <div>Sub-Total:</div>
            <div>R$ {{ number_format($cartTotal, 2, ',', '.') }}</div>
        </div>
        <form action="{{ route('checkout') }}" method="GET">
            <button class="w-full p-2 font-medium text-white bg-primary rounded-xl disabled:bg-gray-300"
                @if (count($cart) == 0) disabled @endif>Finalize the purchase</button>
        </form>
    </div>
</aside>
