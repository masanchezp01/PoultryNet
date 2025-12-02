<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicion;

class MedicionController extends Controller
{
    // Mostrar todas las mediciones
    public function index()
    {
        $mediciones = Medicion::latest()->paginate(10); // 10 registros por página
        return view('site.mediciones.index', compact('mediciones'));
    }


    // Guardar nueva medición IoT
// En tu controlador (MedicionController.php)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'temp_iot' => 'required|numeric',
            'humedad_iot' => 'required|numeric',
            'temp_fisica' => 'required|numeric',
            'humedad_fisica' => 'required|numeric',
        ]);

        // Calcular precisiones
        $precision_temp = $this->calcularPrecision($validated['temp_iot'], $validated['temp_fisica']);
        $precision_hum = $this->calcularPrecision($validated['humedad_iot'], $validated['humedad_fisica']);

        Medicion::create([
            'temp_iot' => $validated['temp_iot'],
            'humedad_iot' => $validated['humedad_iot'],
            'temp_fisica' => $validated['temp_fisica'],
            'humedad_fisica' => $validated['humedad_fisica'],
            'precision_temp' => $precision_temp,
            'precision_hum' => $precision_hum,
        ]);

        return redirect()->route('mediciones.index')
            ->with('success', 'Medición guardada correctamente.');
    }

    private function calcularPrecision($valorIot, $valorFisica)
    {
        if ($valorFisica == 0) return 0; // Evitar división por cero

        $diferencia = abs($valorIot - $valorFisica);
        $precision = (1 - ($diferencia / $valorFisica)) * 100;

        return max(0, min(100, round($precision, 2))); // Asegurar que esté entre 0-100%
    }


    // Actualizar medición física y recalcular precisión
    public function update(Request $request, Medicion $medicion)
    {
        $request->validate([
            'humedad_fisica' => 'nullable|numeric',
            'temp_fisica' => 'nullable|numeric',
        ]);

        if ($request->humedad_fisica) {
            $medicion->humedad_fisica = $request->humedad_fisica;
            $medicion->precision_hum = 100 - abs($medicion->humedad_iot - $request->humedad_fisica) / $request->humedad_fisica * 100;
        }

        if ($request->temp_fisica) {
            $medicion->temp_fisica = $request->temp_fisica;
            $medicion->precision_temp = 100 - abs($medicion->temp_iot - $request->temp_fisica) / $request->temp_fisica * 100;
        }

        $medicion->save();

        return response()->json($medicion);
    }
}
