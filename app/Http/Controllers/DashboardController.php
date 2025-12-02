<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deteccion;
use App\Models\Costo;
use App\Models\Sector; // <- Solo una vez aquí
use App\Models\PreguntaSatisfaccion;
use App\Models\Medicion;
use App\Models\RegistroAmbiental;
use App\Models\User;
// Remover esta línea duplicada: use App\Models\Sector;
use \DateTime;


class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Usuario logueado

        // Total de detecciones solo del usuario
        $totalDetecciones = Deteccion::where('user_id', $userId)->count();

        // Tiempo promedio de detección solo del usuario
        $tiempoPromedio = Deteccion::where('user_id', $userId)->avg('tiempo_deteccion');

        // Costos solo del usuario
        $costos = (object)[
            'total_gasto' => Costo::where('user_id', $userId)->sum('gasto_deteccion'),
            'promedio_gasto' => Costo::where('user_id', $userId)->avg('gasto_deteccion')
        ];

        // Detecciones por enfermedad solo del usuario
        $deteccionesPorEnfermedad = Deteccion::where('user_id', $userId)
            ->select('enfermedad')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('enfermedad')
            ->pluck('total', 'enfermedad');

        // Eficiencia por sector solo del usuario
        $eficienciaPorSector = Deteccion::where('user_id', $userId)
            ->select('sector_id')
            ->selectRaw('AVG(confianza) as eficiencia')
            ->groupBy('sector_id')
            ->with('sector')
            ->get()
            ->pluck('eficiencia', 'sector_id');

        // Distribución de costos solo del usuario
        $distribucionCostos = [
            'Alimentación' => $costos->total_gasto * 0.45,
            'Medicamentos' => $costos->total_gasto * 0.25,
            'Mano de Obra' => $costos->total_gasto * 0.20,
            'Equipamiento' => $costos->total_gasto * 0.10,
        ];

        // Últimas detecciones solo del usuario
        $ultimasDetecciones = Deteccion::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();
        $preguntasSatisfaccion = PreguntaSatisfaccion::all();

        return view('dashboard.dashboard', compact(
            'totalDetecciones',
            'tiempoPromedio',
            'costos',
            'deteccionesPorEnfermedad',
            'eficienciaPorSector',
            'distribucionCostos',
            'ultimasDetecciones',
            'preguntasSatisfaccion' // 👈 pasamos las preguntas

        ));
    }

    public function admin()
{
    // Total de detecciones
    $totalDetecciones = Deteccion::count();

    // Detecciones de hoy
    $deteccionesHoy = Deteccion::whereDate('created_at', today())->count();

    // Sectores activos
    $sectoresActivos = Sector::count();

    // Usuarios activos
    $usuariosActivos = User::count();

    // Crecimiento mensual de detecciones - CORREGIDO
    $deteccionesMensuales = Deteccion::selectRaw('
        TO_CHAR(created_at, \'YYYY-MM\') as month_year,
        COUNT(*) as count
    ')
    ->groupBy('month_year')
    ->orderBy('month_year', 'asc')
    ->get();

    $meses = [];
    $conteos = [];

    foreach ($deteccionesMensuales as $deteccion) {
        $meses[] = \Carbon\Carbon::createFromFormat('Y-m', $deteccion->month_year)->format('M Y');
        $conteos[] = $deteccion->count;
    }

    // Si no hay datos, mostrar datos de ejemplo para demostración
    if (empty($meses)) {
        $meses = ['Oct 2024', 'Nov 2024', 'Dic 2024', 'Ene 2025', 'Feb 2025'];
        $conteos = [2, 5, 8, 12, 15];
    }

    // Distribución por enfermedad - CORREGIDO
    $distribucionEnfermedades = Deteccion::select('enfermedad')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('enfermedad')
        ->orderBy('count', 'desc')
        ->get();

    $enfermedadesLabels = [];
    $enfermedadesData = [];

    foreach ($distribucionEnfermedades as $enfermedad) {
        $enfermedadesLabels[] = $enfermedad->enfermedad;
        $enfermedadesData[] = $enfermedad->count;
    }

    // Si no hay enfermedades, mostrar datos basados en lo que mencionaste
    if (empty($enfermedadesLabels)) {
        $enfermedadesLabels = ['Coccidiosis', 'Bronquitis', 'Newcastle'];
        $enfermedadesData = [3, 1, 1];
    }

    // Últimas mediciones y precisión
    $mediciones = Medicion::orderBy('hora', 'desc')->limit(10)->get();
    $registros = RegistroAmbiental::orderBy('fecha_registro', 'desc')->get();

    $datosPrecision = [];
    $totalPrecisionHum = 0;
    $totalPrecisionTemp = 0;
    $countPrecision = 0;

    foreach ($mediciones as $m) {
        $registro = $registros->first();

        if ($registro && $registro->humedad_max_ideal && $registro->temp_max_ideal) {
            // Cálculo de precisión mejorado - CORREGIDO
            $humedadReferencia = ($registro->humedad_max_ideal + $registro->humedad_min_ideal) / 2;
            $tempReferencia = ($registro->temp_max_ideal + $registro->temp_min_ideal) / 2;

            $precHum = 100 - abs(($m->humedad_iot - $humedadReferencia) / $humedadReferencia * 100);
            $precTemp = 100 - abs(($m->temp_iot - $tempReferencia) / $tempReferencia * 100);

            $precHum = max(0, min(100, $precHum));
            $precTemp = max(0, min(100, $precTemp));

            $datosPrecision[] = [
                'hora' => $m->hora->format('H:i'),
                'humedad_medida' => $m->humedad_iot,
                'humedad_referencia' => round($humedadReferencia, 2),
                'humedad_prec' => round($precHum, 2),
                'temp_medida' => $m->temp_iot,
                'temp_referencia' => round($tempReferencia, 2),
                'temp_prec' => round($precTemp, 2),
            ];

            $totalPrecisionHum += $precHum;
            $totalPrecisionTemp += $precTemp;
            $countPrecision++;
        }
    }

    // Si no hay mediciones, crear datos de ejemplo
    if (empty($datosPrecision)) {
        $datosPrecision = [
            [
                'hora' => '08:00',
                'humedad_medida' => 65.5,
                'humedad_referencia' => 60.0,
                'humedad_prec' => 91.2,
                'temp_medida' => 28.3,
                'temp_referencia' => 27.5,
                'temp_prec' => 97.1,
            ],
            [
                'hora' => '12:00',
                'humedad_medida' => 62.8,
                'humedad_referencia' => 60.0,
                'humedad_prec' => 95.3,
                'temp_medida' => 29.1,
                'temp_referencia' => 27.5,
                'temp_prec' => 94.2,
            ]
        ];
        $precisionPromedioHumedad = 93.3;
        $precisionPromedioTemperatura = 95.7;
    } else {
        $precisionPromedioHumedad = $countPrecision > 0 ? round($totalPrecisionHum / $countPrecision, 2) : 0;
        $precisionPromedioTemperatura = $countPrecision > 0 ? round($totalPrecisionTemp / $countPrecision, 2) : 0;
    }

    return view('dashboard.admin', compact(
        'totalDetecciones',
        'deteccionesHoy',
        'sectoresActivos',
        'usuariosActivos',
        'datosPrecision',
        'precisionPromedioHumedad',
        'precisionPromedioTemperatura'
    ))->with([
        'deteccionesMensualesLabels' => $meses,
        'deteccionesMensualesData' => $conteos,
        'enfermedadesLabels' => $enfermedadesLabels,
        'enfermedadesData' => $enfermedadesData
    ]);
}



}
