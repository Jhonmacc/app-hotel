<?php

namespace App\Http\Controllers;

use App\Models\Hospede;
use App\Models\Contato;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class HospedeController extends Controller
{
    public function index()
    {   // Faz o relacionamento com a tabela contatos e enderecos
        $hospedes = Hospede::with(['contatos', 'endereco'])->get();

        return view('hospedes.index', compact('hospedes'));
    }

    public function create()
{
    return view('hospedes.create');
}

    public function store(Request $request)
    {
        try {
            // Limpar CPF antes de validar
            $cpf = preg_replace('/\D/', '', $request->cpf); // Remove todos os caracteres não numéricos
            $request->merge(['cpf' => $cpf]); // Atualiza o CPF no request para enviar ao banco sem a máscara
            $telefone = preg_replace('/\D/', '', $request->numero); // Limpar telefone
            $request->merge(['cpf' => $cpf, 'numero' => $telefone]);
            $request->validate([
                'nome_completo' => 'required',
                'data_nascimento' => 'required|date',
                'cpf' => 'required|digits:11|unique:hospedes,cpf',
                'email' => 'required|email|unique:contatos,email', // Modificado para tabela contatos
                'numero' => 'required|digits:11',
                'rg' => 'nullable',
                'flag_estrangeiro' => 'boolean',
                'passaporte' => 'nullable',
            ]);

            // Criação do hóspede
            $hospede = Hospede::create($request->only([
                'nome_completo', 'data_nascimento', 'cpf', 'rg', 'flag_estrangeiro', 'passaporte'
            ]));
            $enderecoData = $request->only(['cidade', 'estado', 'pais', 'cep', 'logradouro']);
            $hospede->endereco()->create($enderecoData);

            Contato::create([
                'id_hospede' => $hospede->id,
                'email' => $request->email,
                'numero' => $request->numero,
                'tipo' => 'Email',
            ]);

            // Redireciona com mensagem de sucesso
            return redirect()->route('hospedes.index')->with('success', 'Hóspede cadastrado com sucesso!');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                if (str_contains($e->errorInfo[2], 'cpf')) {
                    $message = 'O CPF informado já está cadastrado.';
                } elseif (str_contains($e->errorInfo[2], 'email')) {
                    $message = 'O Email informado já está cadastrado.';
                } else {
                    $message = 'Erro ao cadastrar hóspede. CPF ou Email duplicado.';
                }

                return back()->withErrors(['error' => $message])->withInput();
            }

            return back()->withErrors(['error' => 'Erro ao cadastrar hóspede: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Hospede $hospede)
{
    return view('hospedes.edit', compact('hospede'));
}


public function update(Request $request, Hospede $hospede)
{
    try {
        // Limpar CPF e número de telefone antes de validar e salvar
        $cpf = preg_replace('/\D/', '', $request->cpf);
        $numero = preg_replace('/\D/', '', $request->numero);
        $request->merge(['cpf' => $cpf, 'numero' => $numero]);

        $request->validate([
            'nome_completo' => 'required',
            'data_nascimento' => 'required|date',
            'cpf' => 'sometimes|size:11|unique:hospedes,cpf,' . $hospede->id,
            'email' => [
                'sometimes',
                'email',
                function ($attribute, $value, $fail) use ($hospede) {
                    if ($hospede->contatos->first() && $hospede->contatos->first()->email !== $value) {
                        if (\App\Models\Contato::where('email', $value)->where('id_hospede', '!=', $hospede->id)->exists()) {
                            $fail('O email já está em uso.');
                        }
                    }
                },
            ],
            'rg' => 'nullable',
            'flag_estrangeiro' => 'boolean',
            'passaporte' => 'nullable',
        ]);

        $hospede->update($request->only([
            'nome_completo', 'data_nascimento', 'cpf', 'rg', 'flag_estrangeiro', 'passaporte'
        ]));

        $enderecoData = $request->only(['cidade', 'estado', 'pais', 'cep', 'logradouro']);
        $hospede->endereco()->updateOrCreate(['id_hospede' => $hospede->id], $enderecoData);

        $hospede->endereco()->update([
            'cidade' => $request->cidade,
        ]);

        $hospede->contatos()->update([
            'email' => $request->email,
            'numero' => $request->numero
        ]);

        return redirect()->route('hospedes.index')->with('success', 'Hóspede atualizado com sucesso!');
    } catch (QueryException $e) {
        if ($e->errorInfo[1] == 1062) {
            if (str_contains($e->errorInfo[2], 'cpf')) {
                $message = 'O CPF informado já está cadastrado.';
            } elseif (str_contains($e->errorInfo[2], 'email')) {
                $message = 'O Email informado já está cadastrado.';
            } else {
                $message = 'Erro ao atualizar hóspede. CPF ou Email duplicado.';
            }

            return back()->withErrors(['error' => $message])->withInput();
        }

        return back()->withErrors(['error' => 'Erro ao atualizar hóspede: ' . $e->getMessage()])->withInput();
    }
}

    public function destroy(Hospede $hospede)
{
    try {
        $hospede->delete();

        return redirect()->route('hospedes.index')->with('success', 'Hóspede deletado com sucesso!');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Erro ao deletar hóspede: ' . $e->getMessage()]);
    }
}

}
