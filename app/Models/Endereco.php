<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_hospede', 'cidade', 'estado', 'pais', 'cep', 'logradouro'
    ];

    public function hospede()
    {
        return $this->belongsTo(Hospede::class, 'id_hospede');
    }
}
