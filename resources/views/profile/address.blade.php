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
                        Endereços cadastrados
                    </div>
                    <div class="flex flex-col w-full gap-4 overflow-y-scroll h-96">
                        @foreach ($address as $add)
                            <div class="flex-1 w-full py-3 border border-gray-100 rounded-lg shadow-sm">
                                <dl class="-my-3 text-sm divide-y divide-gray-100 ">
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Endereço</dt>
                                        <dd class="text-gray-700 sm:col-span-2">{{ $add->address }}</dd>
                                    </div>

                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Complemento</dt>
                                        <dd class="text-gray-700 sm:col-span-2">{{ $add->complement }}</dd>
                                    </div>

                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Cidade</dt>
                                        <dd class="text-gray-700 sm:col-span-2">{{ $add->city }}</dd>
                                    </div>

                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Estado/UF</dt>
                                        <dd class="text-gray-700 sm:col-span-2">
                                            {{ $add->state }}/{{ $add->acronym_state }}</dd>
                                    </div>

                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">CEP</dt>
                                        <dd class="text-gray-700 sm:col-span-2">{{ $add->postal_code }}</dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                        <dt class="font-medium text-gray-900">Pais</dt>
                                        <dd class="text-gray-700 sm:col-span-2">{{ $add->country }}</dd>
                                    </div>
                                    <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-1 sm:gap-4">
                                        <a href="{{ route('profile.address.remove', ['id' => $add->id]) }}"><x-filament::icon
                                                icon="heroicon-o-trash" class="w-4 h-4" /></a>
                                    </div>
                                </dl>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <div class="max-w-xl mb-3 text-lg font-medium">
                        Novo endereço
                    </div>
                    <div class="flex flex-col w-full gap-1">
                        <label>CEP</label>
                        <input required type="text"
                            class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md" id="cep"
                            name="postal_code">
                        <label>Endereço</label>
                        <input required type="text"
                            class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md" id="logradouro"
                            name="address">

                        <label>Complemento</label>
                        <input required type="text"
                            class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md" id="bairro"
                            name="complement">
                        <label>Cidade</label>
                        <input required type="text"
                            class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md" id="localidade"
                            name="city">
                        <label>UF</label>
                        <input required type="text"
                            class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md" id="uf"
                            name="acronym_state">
                        <label>Pais</label>
                        <input required type="text" value="Brasil"
                            class="p-1 mt-2 mb-2 text-sm bg-white border border-gray-300 rounded-md" id="pais"
                            name="country">
                    </div>

                    <div class="w-full mb-3 text-lg font-medium text-right">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-1 mt-4 text-white transition-all rounded-lg cursor-pointer bg-primary hover:bg-primary-dark">Salvar
                            endereço</button>
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
