<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAmbiental extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'registros_ambientales';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sector_id',
        'temp_min_ideal',
        'temp_max_ideal',
        'temp_min_critica',
        'temp_max_critica',
        'humedad_min_ideal',
        'humedad_max_ideal',
        'humedad_min_critica',
        'humedad_max_critica',
        'fecha_registro',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'temp_min_ideal' => 'decimal:2',
        'temp_max_ideal' => 'decimal:2',
        'temp_min_critica' => 'decimal:2',
        'temp_max_critica' => 'decimal:2',
        'humedad_min_ideal' => 'decimal:2',
        'humedad_max_ideal' => 'decimal:2',
        'humedad_min_critica' => 'decimal:2',
        'humedad_max_critica' => 'decimal:2',
        'fecha_registro' => 'datetime',
    ];

    /**
     * Los atributos que deben ser tratados como fechas.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'fecha_registro',
        'created_at',
        'updated_at',
    ];

    // =================== RELACIONES ===================

    /**
     * Relación: Un registro ambiental pertenece a un sector
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    /**
     * Relación: Un registro ambiental puede tener múltiples detecciones
     */
    public function detecciones()
    {
        return $this->hasMany(Deteccion::class, 'registro_ambiental_id');
    }

    // =================== SCOPES ===================

    /**
     * Scope para filtrar registros por sector
     */
    public function scopePorSector($query, $sectorId)
    {
        return $query->where('sector_id', $sectorId);
    }

    /**
     * Scope para filtrar por nivel de riesgo
     */
    public function scopePorNivelRiesgo($query, $nivel)
    {
        return $query->where('estado_riesgo', $nivel);
    }

    /**
     * Scope para obtener registros recientes
     */
    public function scopeRecientes($query, $dias = 7)
    {
        return $query->where('fecha_registro', '>=', now()->subDays($dias));
    }

    /**
     * Scope para obtener registros críticos
     */
    public function scopeCriticos($query)
    {
        return $query->where('estado_riesgo', 'Alto')
            ->orWhere('porcentaje_riesgo', '>=', 70);
    }

    // =================== ACCESSORS ===================

    /**
     * Obtener el estado de riesgo con color
     */
    public function getEstadoRiesgoColorAttribute()
    {
        return match($this->estado_riesgo) {
            'Bajo' => 'green',
            'Medio' => 'yellow',
            'Alto' => 'red',
            default => 'gray',
        };
    }

    /**
     * Obtener el icono según el estado de riesgo
     */
    public function getEstadoRiesgoIconoAttribute()
    {
        return match($this->estado_riesgo) {
            'Bajo' => 'check-circle',
            'Medio' => 'exclamation-triangle',
            'Alto' => 'times-circle',
            default => 'question-circle',
        };
    }

    /**
     * Verificar si la mediciones está en rango ideal
     */
    public function getTemperaturaEnRangoIdealAttribute()
    {
        if (!$this->temp_min_ideal || !$this->temp_max_ideal) {
            return null;
        }

        return $this->temperatura >= $this->temp_min_ideal
            && $this->temperatura <= $this->temp_max_ideal;
    }

    /**
     * Verificar si la humedad está en rango ideal
     */
    public function getHumedadEnRangoIdealAttribute()
    {
        if (!$this->humedad_min_ideal || !$this->humedad_max_ideal) {
            return null;
        }

        return $this->humedad >= $this->humedad_min_ideal
            && $this->humedad <= $this->humedad_max_ideal;
    }

    /**
     * Verificar si hay condiciones críticas
     */
    public function getEsCriticoAttribute()
    {
        $tempCritica = false;
        $humedadCritica = false;

        // Verificar mediciones crítica
        if ($this->temp_min_critica && $this->temperatura < $this->temp_min_critica) {
            $tempCritica = true;
        }
        if ($this->temp_max_critica && $this->temperatura > $this->temp_max_critica) {
            $tempCritica = true;
        }

        // Verificar humedad crítica
        if ($this->humedad_min_critica && $this->humedad < $this->humedad_min_critica) {
            $humedadCritica = true;
        }
        if ($this->humedad_max_critica && $this->humedad > $this->humedad_max_critica) {
            $humedadCritica = true;
        }

        return $tempCritica || $humedadCritica;
    }

    // =================== MÉTODOS ESTÁTICOS ===================

    /**
     * Obtener el último registro de un sector
     */
    public static function ultimoPorSector($sectorId)
    {
        return self::where('sector_id', $sectorId)
            ->latest('fecha_registro')
            ->first();
    }

    /**
     * Calcular promedios de un período
     */
    public static function promediosPorSector($sectorId, $dias = 7)
    {
        return self::where('sector_id', $sectorId)
            ->where('fecha_registro', '>=', now()->subDays($dias))
            ->selectRaw('
                       AVG(mediciones) as temp_promedio,
                       AVG(humedad) as humedad_promedio,
                       AVG(porcentaje_riesgo) as riesgo_promedio
                   ')
            ->first();
    }

    /**
     * Obtener estadísticas de riesgo por sector
     */
    public static function estadisticasRiesgoPorSector($sectorId, $dias = 30)
    {
        return self::where('sector_id', $sectorId)
            ->where('fecha_registro', '>=', now()->subDays($dias))
            ->selectRaw('
                       estado_riesgo,
                       COUNT(*) as total,
                       AVG(porcentaje_riesgo) as riesgo_promedio
                   ')
            ->groupBy('estado_riesgo')
            ->get();
    }

    // =================== MÉTODOS DE INSTANCIA ===================

    /**
     * Obtener recomendaciones basadas en el estado actual
     */
    public function obtenerRecomendaciones()
    {
        $recomendaciones = [];

        // Recomendaciones por mediciones
        if ($this->temperatura < $this->temp_min_ideal) {
            $recomendaciones[] = "⚠️ Temperatura baja. Aumentar calefacción del galpón.";
        } elseif ($this->temperatura > $this->temp_max_ideal) {
            $recomendaciones[] = "⚠️ Temperatura alta. Mejorar ventilación y refrigeración.";
        }

        // Recomendaciones por humedad
        if ($this->humedad < $this->humedad_min_ideal) {
            $recomendaciones[] = "⚠️ Humedad baja. Considerar nebulización.";
        } elseif ($this->humedad > $this->humedad_max_ideal) {
            $recomendaciones[] = "⚠️ Humedad alta. Mejorar ventilación y drenaje.";
        }

        // Recomendaciones críticas
        if ($this->es_critico) {
            $recomendaciones[] = "🚨 CONDICIONES CRÍTICAS. Tomar acción inmediata.";
        }

        // Recomendaciones por nivel de riesgo
        if ($this->estado_riesgo === 'Alto') {
            $recomendaciones[] = "🔴 Monitorear constantemente las condiciones ambientales.";
            $recomendaciones[] = "🔴 Revisar el estado de salud de las aves frecuentemente.";
        }

        return $recomendaciones;
    }

    /**
     * Formatear datos para gráficos
     */
    public function formatearParaGrafico()
    {
        return [
            'fecha' => $this->fecha_registro->format('d/m H:i'),
            'mediciones' => (float) $this->temperatura,
            'humedad' => (float) $this->humedad,
            'riesgo' => (float) $this->porcentaje_riesgo,
            'estado' => $this->estado_riesgo,
        ];
    }
}
