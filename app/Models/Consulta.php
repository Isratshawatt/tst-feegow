<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'consultas';

    protected $fillable = [
        "cliente_id",
        "specialty_id",
        "specialty",
        "professional_id",
        "professional",
        "name",
        "source_id",
        "birthdate",
        "cpf",
        "dateconsult",
    ];

    /**
     * Busca de forma ordenada por data as consultas do cliente
     *
     * @return object
     */
    protected static function buscarConsultasCliente()
    {
        $clienteId = auth()->user()->id;
        return self::where('cliente_id', $clienteId)->orderBy('dateconsult')->get();
    }
}
