<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'id_hospede',
        'numero',
        'email',
        'tipo'
    ];

    // Relacionamento com o hóspede
    public function hospede()
    {
        return $this->belongsTo(Hospede::class, 'id_hospede');
    }
}
