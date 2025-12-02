<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deteccion extends Model
{
    use HasFactory;

    protected $table = 'deteccion';

    protected $fillable = [
        'user_id',
        'sector_id',
        'registro_ambiental_id',
        'imagen_url',
        'enfermedad',
        'confianza',
        'tiempo_deteccion',
        'observaciones',
        'recomendacion'
    ];

    // Relación con RegistroAmbiental
    public function registroAmbiental()
    {
        return $this->belongsTo(RegistroAmbiental::class, 'registro_ambiental_id');
    }

    // Relación con Sector
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
