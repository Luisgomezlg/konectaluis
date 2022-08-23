<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'pro_nombre',
        'pro_referencia',
        'pro_precio',
        'pro_peso',
        'pro_categoria',
        'pro_stock',
        'pro_fecha',
    ];
}
