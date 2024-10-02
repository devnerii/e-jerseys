<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Endereços
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('profile.address.add') }}" method="POST">
            @csrf
            <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <div class="max-w-xl mb-3 text-lg font-medium">
                        Pedidos
                    </div>
                    <div class="flex flex-col w-full gap-10 overflow-y-scroll h-96">
                        @foreach ($orders as $order)
                            <div class="flex-1 w-full py-3 border border-gray-200 rounded-lg shadow-sm">
                                <dl class="-my-3 text-sm divide-y divide-gray-200 ">
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Pedido</dt>
                                        <dd class="text-gray-700 sm:col-span-2">#{{ $order->id }}</dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Estado do pagamento</dt>
                                        <dd class="text-gray-700 sm:col-span-2">
                                            {{ match ($order->payment_status) {
                                                'new' => 'Novo',
                                                'unpaid' => 'Não pago',
                                                'paid' => 'Pago',
                                                'cancelled' => 'Cancelado',
                                            } }}
                                        </dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Estado do pedido</dt>
                                        <dd class="text-gray-700 sm:col-span-2">
                                            {{ match ($order->status) {
                                                'new' => 'Novo',
                                                'processing' => 'Processando',
                                                'shipped' => 'Enviado',
                                                'delivered' => 'Entregue',
                                                'cancelled' => 'Cancelado',
                                            } }}
                                        </dd>
                                    </div>

                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Endereço</dt>
                                        <dd class="text-gray-700 sm:col-span-2">
                                            {{ $order->address }},{{ $order->complement }},
                                            {{ $order->city }}/{{ $order->acronym_state }} - {{ $order->postal_code }}
                                            - {{ $order->country }}</dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-2 p-1 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <div
                                            class="flex flex-col flex-grow w-full col-span-3 gap-4 p-2 overflow-y-auto">
                                            @forelse ($order->items as $item)
                                                @php
                                                    $variant_str = '';
                                                    $variants = $item->variants;
                                                    if ($variants !== null) {
                                                        $variant_str = [];
                                                        foreach ($variants as $key => $variant) {
                                                            $variant_str[] = $key . ': ' . $variant;
                                                        }
                                                        $variant_str = implode(', ', $variant_str);
                                                    }
                                                @endphp
                                                <div
                                                    class="grid grid-cols-7 gap-4 p-3 border border-slate-200 bg-slate-50 rounded-xl">
                                                    <div class="content-center col-span-1 row-span-2"><img
                                                            src="{{ asset('storage/' . $item->product->images[0]) }}"
                                                            alt="" class="w-24"></div>
                                                    <div class="col-span-5">
                                                        <div class="font-medium text-md">{{ $item->product->name }}
                                                        </div>
                                                        <div class="text-xs font-medium">
                                                            {{ $variant_str }}
                                                        </div>

                                                    </div>
                                                    <div class="col-span-1 pr-2 text-sm font-medium text-right"><span
                                                            class="text-xs">R$</span>
                                                        {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                                    </div>
                                                    <div class="col-span-1 text-sm font-medium"><span
                                                            class="text-xs">R$</span>
                                                        {{ $item->product->price }} Un.
                                                    </div>
                                                    <div class="col-span-2 text-sm font-medium">{{ $item->quantity }}
                                                    </div>

                                                    <div class="flex items-center col-span-2 text-sm font-medium">
                                                    </div>
                                                </div>
                                            @empty
                                                <div>Empty cart</div>
                                            @endforelse



                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Subtotal</dt>
                                        <dd class="text-gray-700 sm:col-span-2">R$
                                            {{ number_format($order->subtotal, 2, ',', '.') }}</dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Frete</dt>
                                        <dd class="text-gray-700 sm:col-span-2">R$
                                            {{ number_format($order->shipment_fee, 2, ',', '.') }}</dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Total</dt>
                                        <dd class="text-gray-700 sm:col-span-2">R$
                                            {{ number_format($order->subtotal + $order->shipment_fee, 2, ',', '.') }}
                                        </dd>
                                    </div>



                                </dl>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
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
</x-app-layout>
