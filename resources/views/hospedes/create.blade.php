@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-center">Cadastro de Hóspedes</h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mensagens de erro -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hospedes.store') }}" method="POST" class="max-w-md mx-auto" id="hospede-form">
        @csrf
        <div>
            <label for="nome_completo">Nome Completo</label>
            <input type="text" name="nome_completo" class="border p-2 w-full" required value="{{ old('nome_completo') }}">
        </div>

        <div>
            <label for="data_nascimento">Data de Nascimento</label>
            <input type="date" name="data_nascimento" class="border p-2 w-full" required value="{{ old('data_nascimento') }}">
        </div>

        <div>
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" class="border p-2 w-full" maxlength="14" required value="{{ old('cpf') }}">
        </div>

        <div>
            <label for="telefone">Telefone</label>
            <input type="text" name="numero" id="telefone" class="border p-2 w-full" required value="{{ old('numero') }}">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" class="border p-2 w-full" required value="{{ old('email') }}">
        </div>

        <div>
            <label for="rg">RG</label>
            <input type="text" name="rg" class="border p-2 w-full" value="{{ old('rg') }}">
        </div>

        <div>
            <label for="flag_estrangeiro">É estrangeiro?</label>
            <select name="flag_estrangeiro" class="border p-2 w-full">
                <option value="0" {{ old('flag_estrangeiro') == 0 ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('flag_estrangeiro') == 1 ? 'selected' : '' }}>Sim</option>
            </select>
        </div>

        <div>
            <label for="passaporte">Passaporte</label>
            <input type="text" name="passaporte" class="border p-2 w-full" value="{{ old('passaporte') }}">
        </div>

        <div>
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" class="border p-2 w-full" value="{{ old('cidade', $hospede->endereco->cidade ?? '') }}">
        </div>

        <div>
            <label for="estado">Estado</label>
            <input type="text" name="estado" class="border p-2 w-full" value="{{ old('estado', $hospede->endereco->estado ?? '') }}">
        </div>

        <div>
            <label for="pais">País</label>
            <input type="text" name="pais" class="border p-2 w-full" value="{{ old('pais', $hospede->endereco->pais ?? '') }}">
        </div>

        <div>
            <label for="cep">CEP</label>
            <input type="text" name="cep" class="border p-2 w-full" value="{{ old('cep', $hospede->endereco->cep ?? '') }}">
        </div>

        <div>
            <label for="logradouro">Logradouro</label>
            <input type="text" name="logradouro" class="border p-2 w-full" value="{{ old('logradouro', $hospede->endereco->logradouro ?? '') }}">
        </div>


        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4">Salvar</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var cpfField = document.getElementById('cpf');
        var maskCpf = new Inputmask('999.999.999-99');
        maskCpf.mask(cpfField);

        // Limpar o CPF antes de enviar o formulário
        var form = document.getElementById('hospede-form');
        form.addEventListener('submit', function(event) {
            var cpfValue = cpfField.value;
            // Remover todos os caracteres não numéricos (pontos e traços)
            cpfField.value = cpfValue.replace(/\D/g, ''); // Isso remove qualquer coisa que não seja número
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var telefoneField = document.getElementById('telefone');
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
