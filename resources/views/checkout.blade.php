<x-guest-layout>
    <div class="p-6">
        <div class="my-6 ">
            <h2 class="sr-only">Steps</h2>

            <div>
                <ol
                    class="grid grid-cols-1 overflow-hidden text-sm text-gray-800 border border-gray-100 divide-x divide-gray-100 rounded-lg sm:grid-cols-3">
                    <li
                        class="flex items-center justify-center gap-2 p-4 @if ($checkoutStep == 1) bg-primary-lighter @endif">
                        <svg class="size-7 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>

                        <p class="leading-none">
                            <strong class="block font-medium">Information</strong>
                            <small class="mt-1 text-gray-500"> Personal information.</small>
                        </p>
                    </li>

                    <li
                        class="relative flex items-center justify-center gap-2 p-4  @if ($checkoutStep == 2) bg-primary-lighter @endif">
                        <span
                            class="absolute hidden rotate-45 -translate-y-1/2 border border-gray-100 -left-2 top-1/2 size-4 sm:block ltr:border-b-0 ltr:border-s-0 ltr:bg-white rtl:border-e-0 rtl:border-t-0 rtl:bg-gray-50">
                        </span>

                        <span
                            class="absolute hidden rotate-45 -translate-y-1/2 border border-gray-100 -right-2 top-1/2 size-4 sm:block ltr:border-b-0 ltr:border-s-0 ltr:bg-gray-50 rtl:border-e-0 rtl:border-t-0 rtl:bg-white">
                        </span>

                        <svg class="size-7 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <p class="leading-none">
                            <strong class="block font-medium">Address</strong>
                            <small class="mt-1 text-gray-500"> Delivery address and shipping method.</small>
                        </p>
                    </li>

                    <li
                        class="flex items-center justify-center gap-2 p-4 @if ($checkoutStep == 3) bg-primary-lighter @endif">
                        <svg class="size-7 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>

                        <p class="leading-none">
                            <strong class="block font-medium"> Payment </strong>
                            <small class="mt-1 text-gray-500"> Payment method. </small>
                        </p>
                    </li>
                </ol>
            </div>
        </div>
        @if ($checkoutStep == 1)

            <div class="flow-root py-3 mb-4 border border-gray-100 rounded-lg shadow-sm">
                <dl class="-my-3 text-sm divide-y divide-gray-100">
                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                        <dt class="font-medium text-gray-900">Name</dt>
                        <dd class="text-gray-700 sm:col-span-2">{{ Auth()->user()->name }}</dd>
                    </div>
                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                        <dt class="font-medium text-gray-900">Email</dt>
                        <dd class="text-gray-700 sm:col-span-2">{{ Auth()->user()->email }}</dd>
                    </div>
                </dl>
            </div>
            <div class="flow-root py-3 mb-4 border border-gray-100 rounded-lg shadow-sm">
                <div class="-my-3 text-sm divide-y divide-gray-100">
                    <div
                        class="grid grid-cols-1 col-span-2 col-span-3 gap-1 p-3 font-medium text-gray-900 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                        Shopping cart
                    </div>
                    <div class="grid grid-cols-1 gap-1 p-1 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                        <div class="flex flex-col flex-grow w-full col-span-3 gap-4 p-2 overflow-y-auto">

                            @php
                                $cart = session()->get('cart', []);
                                $cartTotal = session()->get('cart-total', 0.0);
                                $cartDiscountedTotal = session()->get('cart-discount-total', 0.0);
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
                                <div class="grid grid-cols-7 gap-4 p-2 bg-white rounded-xl">
                                    <div class="content-center col-span-1 row-span-2"><img
                                            src="{{ asset('storage/' . $product['image']) }}" alt=""
                                            class="w-24"></div>
                                    <div class="col-span-5">
                                        <div class="font-medium text-md">{{ $product['name'] }}</div>
                                        <div class="text-xs font-medium">
                                            {{ $product['variant_str'] }}
                                        </div>

                                    </div>
                                    <div class="col-span-1 text-sm font-medium">
                                        @if ($product['price'] != $product['discounted_price'])
                                            {{ formatCurrency($product['discounted_price'] * $product['quantity']) }}
                                            <span class="text-sm font-normal text-gray-600 line-through">
                                                {{ formatCurrency($product['price'] * $product['quantity']) }}
                                            </span>
                                        @else
                                            {{ formatCurrency($product['price'] * $product['quantity']) }}
                                        @endif
                                    </div>
                                    <div class="col-span-1 text-sm font-medium">
                                        @if ($product['price'] != $product['discounted_price'])
                                            {{ formatCurrency($product['discounted_price']) }}
                                            <span class="text-sm font-normal text-gray-600 line-through">
                                                {{ formatCurrency($product['price']) }}
                                            </span>
                                        @else
                                            {{ formatCurrency($product['price']) }} 
                                        @endif

                                        Un.
                                    </div>
                                    <div class="flex col-span-2 font-medium h-14 md:h-12 rounded-xl text-md">
                                        <div
                                            class="inline-flex items-center font-medium border border-gray-300 h-14 md:h-12 rounded-xl text-md">
                                            <a href="{{ route('site.cart.minus', [$product['id'], $product['hash']]) }}"
                                                class="inline-block p-3"><x-filament::icon icon="heroicon-o-minus"
                                                    class="w-4 h-4" /></a>
                                            <input type="number"
                                                class="w-1 p-2 text-center bg-transparent border-0 md:w-12 focus:ring-transparent focus:outline-none  [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                                                value="{{ $product['quantity'] }}" min="0" max="1000" />
                                            <a href="{{ route('site.cart.plus', [$product['id'], $product['hash']]) }}"
                                                class="inline-block p-3"><x-filament::icon icon="heroicon-o-plus"
                                                    class="w-4 h-4" /></a>
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
                    </div>
                    <div class="grid grid-cols-2 gap-1 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                        <div class="flex-shrink w-full col-span-2 p-4 sm:col-span-3 ">
                            <div class="flex justify-between py-2 text-lg font-medium">
                                <div>Sub-Total:</div>
                                <div>
                                    @if ($cartTotal != $cartDiscountedTotal)
                                        {{ formatCurrency($cartDiscountedTotal) }}
                                        <span class="text-sm font-normal text-gray-600 line-through">
                                            {{ formatCurrency($cartTotal) }}
                                        </span>
                                    @else
                                        {{ formatCurrency($cartTotal) }}
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-between py-2 text-lg font-medium">
                                <div>Freight:</div>
                                <div>{{ formatCurrency(0.0) }}</div>
                            </div>
                            <div class="flex justify-between py-2 text-lg font-medium">
                                <div>Total:</div>
                                <div>{{ formatCurrency($cartDiscountedTotal) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex justify-between mt-8 mb-16 text-sm" x-data="{ hoverNext: false, hover: false }">

                <a href="{{ route('site.home') }}" x-on:mouseover="hover = true" x-on:mouseleave="hover = false"
                    x-bind:class="{ 'pl-10': hover, 'pl-4': !hover }"
                    class="relative inline-block py-2 pr-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                    Continue shopping
                    <x-filament::icon icon="heroicon-c-arrow-left"
                        class="absolute transition-all w-5 h-5 left-3 top-2.5"
                        x-bind:class="{ 'translate-x-0': hover, '-translate-x-8': !hover }" />
                </a>

                <a href="{{ route('checkout', ['next' => true]) }}" x-on:mouseover="hoverNext = true"
                    x-on:mouseleave="hoverNext = false" x-bind:class="{ 'pr-10': hoverNext, 'pr-4': !hoverNext }"
                    class="relative inline-block py-2 pl-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                    Next
                    <x-filament::icon icon="heroicon-c-arrow-right"
                        class="absolute transition-all w-5 h-5 right-3 top-2.5"
                        x-bind:class="{ 'translate-x-0': hoverNext, 'translate-x-8': !hoverNext }" />
                </a>
            </div>
        @endif
        @if ($checkoutStep == 2)
            @php
                $shipping = App\Models\Shipping::all();
                $states_list = App\Models\State::all();
                $ufs = [];
                $ufs[''] = 0.0;

                foreach ($shipping as $s) {
                    $ufs[trim($s->acronym_state)] = floatval($s->shipment_fee);
                }
                $states = [];
                foreach ($states_list as $s) {
                    $states[$s->acronym_state] = $s->state;
                }
                $ufs_address = [];
                $addresses = App\Models\Address::where('user_id', Auth()->user()->id)->get();
            @endphp
            @foreach ($addresses as $address)
                @php
                    $ufs_address[$address->id] = $address->acronym_state;
                @endphp
            @endforeach
            <form action="{{ route('checkout', ['next' => true]) }}" method="POST">
                @csrf
                @php
                    $cart = session()->get('cart', []);
                    $cartTotal = session()->get('cart-total', 0.0);
                    $cartDiscountedTotal = session()->get('cart-discount-total', 0.0);
                @endphp
                <div id="addr" x-data="{
                    addressType: 'registerd',
                    addressId: 0.0,
                    ufs: @js($ufs),
                    ufs_address: @js($ufs_address),
                    states: @js($states),
                    frete: 0.0,
                    total: @js($cartDiscountedTotal),
                    cep: '',
                    logradouro: '',
                    bairro: '',
                    localidade: '',
                    state: '',
                    addressUf: '',
                    pais: 'Brasil',
                    viaCep() {
                        let cleanCep = this.cep.replace(/\D/g, '');
                        if (cleanCep.length == 8) {
                            fetch('https://viacep.com.br/ws/' + cleanCep + '/json/')
                                .then(response => response.json())
                                .then(data => {
                                    this.logradouro = data.logradouro;
                                    this.bairro = data.bairro;
                                    this.localidade = data.localidade;
                                    this.addressUf = data.uf;
                                    this.state = this.states[this.addressUf] || '';
                                    this.frete = this.ufs[this.addressUf] || 0.0;
                                });

                        }
                    },
                }">
                    <div>
                        <div class="flow-root py-3 mb-4 border border-gray-100 rounded-lg shadow-sm">
                            <dl class="-my-3 text-sm divide-y divide-gray-100">
                                <div
                                    class="grid grid-cols-1 col-span-2 col-span-3 gap-1 p-3 text-xl font-medium text-gray-900 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                    Delivery address
                                </div>
                                <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                    <dt class="font-medium text-gray-900">
                                        <label>
                                            <input type="radio" name="address_type" value="registerd"
                                                x-on:click="addressType = 'registerd'"
                                                x-bind:checked="addressType === 'registerd'">
                                            Registered address
                                        </label>
                                    </dt>
                                    <dd class="text-gray-700 sm:col-span-2">
                                        <div class="relative flex flex-col overflow-hidden">
                                            <div
                                                class="flex flex-col transition-all duration-300 ease-in-out"x-bind:class="{
                                                    'translate-y-0 h-auto': addressType ==
                                                        'registerd',
                                                    '-translate-y-full h-0': addressType != 'registerd'
                                                }">
                                                <select
                                                    class="w-full p-1 mt-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    name="address_id" x-bind:disabled="addressType == 'new'"
                                                    x-on:change="frete = ufs[ufs_address[addressId]] || 0.0"
                                                    x-model="addressId" required>
                                                    <option value="">Select an address</option>
                                                    @foreach ($addresses as $address)
                                                        <option value="{{ $address->id }}">{{ $address->address }} -
                                                            {{ $address->complement }},
                                                            {{ $address->city }}, {{ $address->acronym_state }} -
                                                            {{ $address->postal_code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                                <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                    <dt class="font-medium text-gray-900">

                                        <label>
                                            <input type="radio" name="address_type" value="new"
                                                x-on:click="addressType = 'new'"
                                                x-bind:checked="addressType === 'new'">
                                            New address
                                        </label>

                                    </dt>
                                    <dd class="text-gray-700 sm:col-span-2">
                                        <div class="relative flex flex-col overflow-hidden">
                                            <div
                                                class="flex flex-col transition-all duration-300 ease-in-out"x-bind:class="{
                                                    'translate-y-0 h-auto': addressType ==
                                                        'new',
                                                    '-translate-y-full h-0': addressType != 'new'
                                                }">
                                                <label>CEP</label>
                                                <input type="text"
                                                    class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    x-bind:disabled="addressType == 'registerd'" x-model="cep"
                                                    name="postal_code" x-bind:required="addressType == 'new'"
                                                    x-on:keyup="viaCep()" x-mask="99.999-999" max="10">
                                                <label>Endereço</label>
                                                <input type="text"
                                                    class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    x-bind:disabled="addressType == 'registerd'" x-model="logradouro"
                                                    name="address" x-bind:required="addressType == 'new'">

                                                <label>Complemento</label>
                                                <input type="text"
                                                    class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    x-bind:disabled="addressType == 'registerd'" x-model="bairro"
                                                    name="complement" x-bind:required="addressType == 'new'">
                                                <label>Cidade</label>
                                                <input type="text"
                                                    class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    x-bind:disabled="addressType == 'registerd'" x-model="localidade"
                                                    name="city" x-bind:required="addressType == 'new'">
                                                <label>Estado</label>
                                                <input type="text"
                                                    class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    x-bind:disabled="addressType == 'registerd'" x-model="state"
                                                    name="state" x-bind:required="addressType == 'new'">
                                                <label>UF</label>
                                                <input type="text"
                                                    class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    x-bind:disabled="addressType == 'registerd'" x-model="addressUf"
                                                    name="acronym_state" x-bind:required="addressType == 'new'"
                                                    x-on:change="frete = ufs[addressUf] || 0.0">
                                                <label>Pais</label>
                                                <input type="text" value="Brasil"
                                                    class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md"
                                                    x-bind:disabled="addressType == 'registerd'" x-model="pais"
                                                    name="country" x-bind:required="addressType == 'new'">
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div class="flow-root py-3 mb-4 border border-gray-100 rounded-lg shadow-sm">
                        <div class="-my-3 text-sm divide-y divide-gray-100">
                            <div
                                class="grid grid-cols-1 col-span-2 col-span-3 gap-1 p-3 text-xl font-medium text-gray-900 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                Shopping cart
                            </div>
                            <div class="grid grid-cols-1 gap-1 p-1 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <div class="flex flex-col flex-grow w-full col-span-3 gap-4 p-2 overflow-y-auto">
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
                                        <div class="grid grid-cols-7 gap-4 p-3 bg-white rounded-xl">
                                            <div class="content-center col-span-1 row-span-2"><img
                                                    src="{{ asset('storage/' . $product['image']) }}" alt=""
                                                    class="w-24"></div>
                                            <div class="col-span-5">
                                                <div class="font-medium text-md">{{ $product['name'] }}</div>
                                                <div class="text-xs font-medium">
                                                    {{ $product['variant_str'] }}
                                                </div>

                                            </div>
                                            <div class="col-span-1 text-sm font-medium">
                                                @if ($product['price'] != $product['discounted_price'])
                                                    {{ formatCurrency($product['discounted_price'] * $product['quantity']) }}
                                                    <span class="text-sm font-normal text-gray-600 line-through">
                                                        {{ formatCurrency($product['price'] * $product['quantity']) }}
                                                    </span>
                                                @else
                                                    {{ formatCurrency($product['price'] * $product['quantity']) }}
                                                @endif
                                            </div>
                                            <div class="col-span-1 text-sm font-medium">
                                                @if ($product['price'] != $product['discounted_price'])
                                                    {{ formatCurrency($product['discounted_price']) }}
                                                    <span class="text-sm font-normal text-gray-600 line-through">
                                                        {{ formatCurrency($product['price']) }}
                                                    </span>
                                                @else
                                                    {{ formatCurrency($product['price']) }} 
                                                @endif

                                                Un.
                                            </div>
                                            <div class="flex col-span-2 font-medium h-14 md:h-12 rounded-xl text-md">
                                                <div
                                                    class="inline-flex items-center font-medium border border-gray-300 h-14 md:h-12 rounded-xl text-md">
                                                    <a href="{{ route('site.cart.minus', [$product['id'], $product['hash']]) }}"
                                                        class="inline-block p-3"><x-filament::icon
                                                            icon="heroicon-o-minus" class="w-4 h-4" /></a>
                                                    <input type="number"
                                                        class="w-1 p-2 text-center bg-transparent border-0 md:w-12 focus:ring-transparent focus:outline-none  [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                                                        value="{{ $product['quantity'] }}" min="0"
                                                        max="1000" />
                                                    <a href="{{ route('site.cart.plus', [$product['id'], $product['hash']]) }}"
                                                        class="inline-block p-3"><x-filament::icon
                                                            icon="heroicon-o-plus" class="w-4 h-4" /></a>
                                                </div>
                                            </div>
                                            <div class="flex items-center col-span-2 text-sm font-medium">
                                                <a
                                                    href="{{ route('site.cart.remove', [$product['id'], $product['hash']]) }}"><x-filament::icon
                                                        icon="heroicon-o-trash" class="w-4 h-4" /></a>
                                            </div>
                                        </div>
                                    @empty
                                        <div>Empty cart</div>
                                    @endforelse



                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <div class="flex-shrink w-full col-span-2 p-4 sm:col-span-3 ">
                                    <div class="flex justify-between py-2 font-medium text-md">
                                        <div>Sub-Total:</div>
                                        <div>
                                            @if ($cartTotal != $cartDiscountedTotal)
                                                {{ formatCurrency($cartDiscountedTotal) }}
                                                <span class="text-sm font-normal text-gray-600 line-through">
                                                    {{ formatCurrency($cartTotal) }}
                                                </span>
                                            @else
                                                {{ formatCurrency($cartTotal) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex justify-between py-2 font-medium text-md">
                                        <div>Freight:</div>
                                        <div x-text="'{{ $currencySymbol }} ' + (frete.toFixed(2)).replace('.', ',')">-</div>
                                        <input type="hidden" name="shipment_fee" x-bind:value="frete">
                                    </div>
                                    <div class="flex justify-between py-2 text-lg font-medium">
                                        <div>Total:</div>
                                        <div x-text="'{{ $currencySymbol }} '+(total + 0.0 + frete).toFixed(2).replace('.', ',')">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8 mb-16 text-sm" x-data="{ hoverNext: false, hover: false }">

                        <a href="{{ route('checkout', ['prev' => true]) }}" x-on:mouseover="hover = true"
                            x-on:mouseleave="hover = false" x-bind:class="{ 'pl-10': hover, 'pl-4': !hover }"
                            class="relative inline-block py-2 pr-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                            Previous
                            <x-filament::icon icon="heroicon-c-arrow-left"
                                class="absolute transition-all w-5 h-5 left-3 top-2.5"
                                x-bind:class="{ 'translate-x-0': hover, '-translate-x-8': !hover }" />
                        </a>

                        <button type="submit" x-on:mouseover="hoverNext = true" x-on:mouseleave="hoverNext = false"
                            x-bind:class="{ 'pr-10': hoverNext, 'pr-4': !hoverNext }"
                            class="relative inline-block py-2 pl-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                            Next
                            <x-filament::icon icon="heroicon-c-arrow-right"
                                class="absolute transition-all w-5 h-5 right-3 top-2.5"
                                x-bind:class="{ 'translate-x-0': hoverNext, 'translate-x-8': !hoverNext }" />
                        </button>
                    </div>
                </div>
            </form>
        @endif
        @if ($checkoutStep == 3)
            <div class="flex justify-between mt-8 mb-16 text-sm" x-data="{ hoverNext: false, hover: false }">
                <a href="{{ route('checkout', ['prev' => true]) }}" x-on:mouseover="hover = true"
                    x-on:mouseleave="hover = false" x-bind:class="{ 'pl-10': hover, 'pl-4': !hover }"
                    class="relative inline-block py-2 pr-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                    Anterior
                    <x-filament::icon icon="heroicon-c-arrow-left"
                        class="absolute transition-all w-5 h-5 left-3 top-2.5"
                        x-bind:class="{ 'translate-x-0': hover, '-translate-x-8': !hover }" />
                </a>

                <a href="{{ route('checkout', ['next' => true]) }}" x-on:mouseover="hoverNext = true"
                    x-on:mouseleave="hoverNext = false" x-bind:class="{ 'pr-10': hoverNext, 'pr-4': !hoverNext }"
                    class="relative inline-block py-2 pl-4 overflow-hidden font-bold text-center text-white transition-all cursor-pointer bg-primary hover:bg-primary-dark rounded-xl">
                    Próximo
                    <x-filament::icon icon="heroicon-c-arrow-right"
                        class="absolute transition-all w-5 h-5 right-3 top-2.5"
                        x-bind:class="{ 'translate-x-0': hoverNext, 'translate-x-8': !hoverNext }" />
                </a>
            </div>
        @endif
    </div>
    @if ($checkoutStep == 2)
        {{--
        <script>
            const formatar_cep = cep => {
                cep = cep.replace(/\D/g, '')
                return cep
            }

            const buscar_cep = async () => {
                let cep = document.querySelector('#cep').value
                cep = formatar_cep(cep)

                if (cep.length == 8) {
                    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    const data = await response.json()
                    if (typeof data.erro != 'undefined') return alert('CEP não encontrado')

                    return data
                }
            }

            document.querySelector('#cep').addEventListener('keyup', async () => {
                const data = await buscar_cep()
                if (data == undefined) return

                const logradouro_field = document.querySelector('#logradouro')
                const bairro_field = document.querySelector('#bairro')
                const localidade_field = document.querySelector('#localidade')
                const uf_field = document.querySelector('#uf')

                logradouro_field.value = data.logradouro
                bairro_field.value = data.bairro
                localidade_field.value = data.localidade
                uf_field.value = data.uf

                Alpine.data('addressUf', () => data.uf)
                renderiza_mudancas()
            })

            const renderiza_mudancas = () => {
                const logradouro_field = document.querySelector('#logradouro')
                const bairro_field = document.querySelector('#bairro')
                const localidade_field = document.querySelector('#localidade')
                const uf_field = document.querySelector('#uf')
                const cep_field = document.querySelector('#cep')
                logradouro_field.focus()
                bairro_field.focus()
                localidade_field.focus()
                uf_field.focus()
                cep_field.focus()


            }
        </script>
        --}}
    @endif
</x-guest-layout>
