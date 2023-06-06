<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'dbo.Produto';
    protected $primaryKey = 'CO_PRODUTO';
    public $timestamps = false;

    protected $fillable = [
        'NO_PRODUTO',
        'PC_TAXA_JUROS',
        'NU_MINIMO_MESES',
        'NU_MAXIMO_MESES',
        'VR_MINIMO',
        'VR_MAXIMO',
    ];
}

