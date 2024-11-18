@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Lista de Hóspedes</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('hospedes.create') }}" class="bg-blue-500 text-white px-4 py-2 mb-4 inline-block">Cadastrar Hóspede</a>

    <table id="hospedes-table" class="ui celled table nowrap unstackable w-full text-sm text-left" >
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-2 border">Ações</th>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Nome Completo</th>
                <th class="p-2 border">Data de Nascimento</th>
                <th class="p-2 border">CPF</th>
                <th class="p-2 border">Contato</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">RG</th>
                <th class="p-2 border">Estrangeiro</th>
                <th class="p-2 border">Cidade</th>
                <th class="p-2 border">Passaporte</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hospedes as $hospede)
            <tr class="hover:bg-gray-100">
                <td class="p-2 border relative">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md focus:outline-none" onclick="toggleActions({{ $hospede->id }})">Ações</button>
                    <div id="actions-{{ $hospede->id }}" class="hidden mt-2 bg-white shadow-lg rounded-md flex">
                        <a href="{{ route('hospedes.edit', $hospede->id) }}" class="block text-blue-500 hover:bg-gray-200 px-4 py-2">Editar</a>
                        <form action="{{ route('hospedes.destroy', $hospede->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block text-red-500 hover:bg-gray-200 px-4 py-2">Deletar</button>
                        </form>
                    </div>
                </td>

                <td class="p-2 border">{{ $hospede->id }}</td>
                <td class="p-2 border">{{ $hospede->nome_completo }}</td>
                <td class="p-2 border">{{ \Carbon\Carbon::parse($hospede->data_nascimento)->format('d/m/Y') }}</td>
                <td class="p-2 border">{{ $hospede->cpf }}</td>
                <td class="p-2 border">
                    @if($hospede->contatos)
                    <p>{{ $hospede->contatos->numero }}</p>
                @else
                    <p>Este hóspede não tem um contato registrado.</p>
                @endif
                </td>
                <td class="p-2 border">
                    @if($hospede->contatos)
                    <p>{{ $hospede->contatos->email }}</p>
                @else
                    <p>Este hóspede não tem um contato registrado.</p>
                @endif
                </td>
                <td class="p-2 border">{{ $hospede->rg }}</td>
                <td class="p-2 border">
                    @if($hospede->flag_estrangeiro == 0)
                        <span class="text-red-500">Não</span>
                    @else
                        <span class="text-green-500">Sim</span>
                    @endif
                </td>
                <td class="p-2 border">
                    @if($hospede->endereco)
                    <p>{{ $hospede->endereco->cidade }}</p>
                @else
                    <p>Este hóspede não tem uma cidade registrada.</p>
                @endif
                </td>
                <td class="p-2 border">{{ $hospede->passaporte }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
<script>
  function toggleActions(id) {
    const menu = document.getElementById(`actions-${id}`);
    const isVisible = !menu.classList.contains('hidden');

    // Fecha todos os menus abertos
    document.querySelectorAll('[id^="actions-"]').forEach(el => {
        el.classList.add('hidden');
    });

    // Alterna a visibilidade do menu clicado
    if (!isVisible) {
        menu.classList.remove('hidden');
    }
}

// Fecha o menu ao clicar fora
document.addEventListener('click', function (event) {
    const isButtonClick = event.target.closest('button');
    const isMenuClick = event.target.closest('[id^="actions-"]');

    if (!isButtonClick && !isMenuClick) {
        document.querySelectorAll('[id^="actions-"]').forEach(el => {
            el.classList.add('hidden');
        });
    }
});

</script>
@endsection
