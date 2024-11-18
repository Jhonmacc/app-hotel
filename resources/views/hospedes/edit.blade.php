@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-center">Editar Hóspede</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="hospede-form" action="{{ route('hospedes.update', $hospede->id) }}" method="POST" class="max-w-md mx-auto">
        @csrf
        @method('PUT')

        <div>
            <label for="nome_completo">Nome Completo</label>
            <input type="text" name="nome_completo" value="{{ old('nome_completo', $hospede->nome_completo) }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label for="data_nascimento">Data de Nascimento</label>
            <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $hospede->data_nascimento) }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label for="cpf">CPF</label>
            <input id="cpf" type="text" name="cpf" value="{{ old('cpf', $hospede->cpf) }}" class="border p-2 w-full" maxlength="14" required>
        </div>

        <div>
            <label for="telefone">Telefone</label>
            <input type="text" name="numero" id="numero" class="border p-2 w-full" required value="{{ old('numero', $hospede->contatos->numero ?? '') }}">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $hospede->contatos->email) }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label for="rg">RG</label>
            <input type="text" name="rg" value="{{ old('rg', $hospede->rg) }}" class="border p-2 w-full">
        </div>

        <div>
            <label for="flag_estrangeiro">É estrangeiro?</label>
            <select name="flag_estrangeiro" class="border p-2 w-full">
                <option value="0" {{ old('flag_estrangeiro', $hospede->flag_estrangeiro) == 0 ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('flag_estrangeiro', $hospede->flag_estrangeiro) == 1 ? 'selected' : '' }}>Sim</option>
            </select>
        </div>

        <div>
            <label for="passaporte">Passaporte</label>
            <input type="text" name="passaporte" value="{{ old('passaporte', $hospede->passaporte) }}" class="border p-2 w-full">
        </div>

        <div>
            <label for="telefone">Cidade</label>
            <input type="text" name="cidade" id="cidade" class="border p-2 w-full" required value="{{ old('cidade', $hospede->endereco->cidade ?? '') }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4">Atualizar</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Máscara CPF
        var cpfField = document.getElementById('cpf');
        var maskCpf = new Inputmask('999.999.999-99');
        maskCpf.mask(cpfField);

        // Limpar o CPF antes de enviar o formulário
        var form = document.getElementById('hospede-form');
        form.addEventListener('submit', function(event) {
            var cpfValue = cpfField.value;
            // Remove todos os caracteres não numéricos (pontos e traços)
            cpfField.value = cpfValue.replace(/\D/g, '');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var telefoneField = document.getElementById('numero');
        var maskTelefone = new Inputmask('(99)99999-9999');
        maskTelefone.mask(telefoneField);

        // Limpar o telefone antes de enviar o formulário
        var form = document.getElementById('hospede-form');
        form.addEventListener('submit', function(event) {
            var telefoneValue = telefoneField.value;
            telefoneField.value = telefoneValue.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        });
    });
</script>

@endsection
