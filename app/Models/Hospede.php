<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospede extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'data_nascimento',
        'cpf',
        'rg',
        'flag_estrangeiro',
        'passaporte',
    ];

    public function contatos()
    {
        return $this->hasOne(Contato::class, 'id_hospede');
    }
    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id_hospede');
    }

}
