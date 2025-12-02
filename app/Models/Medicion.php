<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicion extends Model
{
    use HasFactory;
    protected $table = 'mediciones'; // <- esto indica el nombre correcto de la tabla

    protected $fillable = [
        'hora',
        'humedad_iot',
        'temp_iot',
        'humedad_fisica',
        'temp_fisica',
        'precision_hum',
        'precision_temp'
    ];

    protected $casts = [
        'hora' => 'datetime',
        'humedad_iot' => 'float',
        'temp_iot' => 'float',
        'humedad_fisica' => 'float',
        'temp_fisica' => 'float',
        'precision_hum' => 'float',
        'precision_temp' => 'float',
    ];
}
