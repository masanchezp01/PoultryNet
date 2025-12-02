<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\RegistroAmbiental;
use App\Models\Sector;
use Illuminate\Http\Request;

class RegistroAmbientalController extends Controller
{
    /**
     * Mostrar la lista de configuraciones
     */
    public function index()
    {
        $registros = RegistroAmbiental::with('sector')->get();
        return view('site.registros_ambientales.index', compact('registros'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        // Obtener los IDs de sectores que ya tienen configuración
        $sectoresConfigurados = RegistroAmbiental::pluck('sector_id')->toArray();

        // Traer solo los sectores del usuario autenticado que no estén configurados
        $sectores = Sector::where('user_id', auth()->id())
            ->whereNotIn('id', $sectoresConfigurados)
            ->get();

        return view('site.registros_ambientales.create', compact('sectores'));
    }

    /**
     * Guardar configuración ambiental
     */

    public function store(Request $request)
    {
        // Log de los datos que llegan
        Log::info('Store RegistroAmbiental Request Data', $request->all());

        // Validación inicial
        $validated = $request->validate([
            'sector_id' => 'required|exists:sectores,id',
            'temp_min_ideal' => 'required|numeric|min:-50|max:100',
            'temp_max_ideal' => 'required|numeric|min:-50|max:100',
            'temp_min_critica' => 'required|numeric|min:-50|max:100',
            'temp_max_critica' => 'required|numeric|min:-50|max:100',
            'humedad_min_ideal' => 'required|numeric|min:0|max:100',
            'humedad_max_ideal' => 'required|numeric|min:0|max:100',
            'humedad_min_critica' => 'required|numeric|min:0|max:100',
            'humedad_max_critica' => 'required|numeric|min:0|max:100',
        ]);

        // Validaciones lógicas adicionales
        if ($validated['temp_min_ideal'] >= $validated['temp_max_ideal']) {
            return back()
                ->withErrors(['temp_min_ideal' => 'La mediciones mínima ideal debe ser menor que la máxima ideal'])
                ->withInput();
        }
        if ($validated['humedad_min_ideal'] >= $validated['humedad_max_ideal']) {
            return back()
                ->withErrors(['humedad_min_ideal' => 'La humedad mínima ideal debe ser menor que la máxima ideal'])
                ->withInput();
        }
        if ($validated['temp_min_critica'] >= $validated['temp_max_critica']) {
            return back()
                ->withErrors(['temp_min_critica' => 'La mediciones mínima crítica debe ser menor que la máxima crítica'])
                ->withInput();
        }
        if ($validated['humedad_min_critica'] >= $validated['humedad_max_critica']) {
            return back()
                ->withErrors(['humedad_min_critica' => 'La humedad mínima crítica debe ser menor que la máxima crítica'])
                ->withInput();
        }
        if ($validated['temp_min_ideal'] < $validated['temp_min_critica']) {
            return back()
                ->withErrors(['temp_min_ideal' => 'La mediciones mínima ideal debe ser mayor o igual a la mínima crítica'])
                ->withInput();
        }
        if ($validated['temp_max_ideal'] > $validated['temp_max_critica']) {
            return back()
                ->withErrors(['temp_max_ideal' => 'La mediciones máxima ideal debe ser menor o igual a la máxima crítica'])
                ->withInput();
        }
        if ($validated['humedad_min_ideal'] < $validated['humedad_min_critica']) {
            return back()
                ->withErrors(['humedad_min_ideal' => 'La humedad mínima ideal debe ser mayor o igual a la mínima crítica'])
                ->withInput();
        }
        if ($validated['humedad_max_ideal'] > $validated['humedad_max_critica']) {
            return back()
                ->withErrors(['humedad_max_ideal' => 'La humedad máxima ideal debe ser menor o igual a la máxima crítica'])
                ->withInput();
        }

        // 🔹 Asignar un valor por defecto a 'mediciones' si no se envía
        $validated['mediciones'] = $request->mediciones ?? $validated['temp_max_ideal'];

        // Guardar la configuración
        try {
            $registro = RegistroAmbiental::create($validated);

            Log::info('RegistroAmbiental creado', $registro->toArray());

            return redirect()
                ->route('registros_ambientales.index')
                ->with('success', 'Configuración guardada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al guardar RegistroAmbiental', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return back()
                ->withErrors(['error' => 'Error al guardar la configuración: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $registro = RegistroAmbiental::findOrFail($id);
        $sectores = Sector::where('user_id', auth()->id())->get();

        return view('site.registros_ambientales.edit', compact('registro', 'sectores'));
    }

    /**
     * Actualizar configuración
     */
    public function update(Request $request, $id)
    {
        $registro = RegistroAmbiental::findOrFail($id);

        // Validación
        $validated = $request->validate([
            'sector_id' => 'required|exists:sectores,id',
            'temp_min_ideal' => 'required|numeric|min:-50|max:100',
            'temp_max_ideal' => 'required|numeric|min:-50|max:100',
            'temp_min_critica' => 'required|numeric|min:-50|max:100',
            'temp_max_critica' => 'required|numeric|min:-50|max:100',
            'humedad_min_ideal' => 'required|numeric|min:0|max:100',
            'humedad_max_ideal' => 'required|numeric|min:0|max:100',
            'humedad_min_critica' => 'required|numeric|min:0|max:100',
            'humedad_max_critica' => 'required|numeric|min:0|max:100',
        ]);

        // Validaciones lógicas
        if ($validated['temp_min_ideal'] >= $validated['temp_max_ideal']) {
            return back()
                ->withErrors(['temp_min_ideal' => 'La mediciones mínima ideal debe ser menor que la máxima ideal'])
                ->withInput();
        }

        if ($validated['humedad_min_ideal'] >= $validated['humedad_max_ideal']) {
            return back()
                ->withErrors(['humedad_min_ideal' => 'La humedad mínima ideal debe ser menor que la máxima ideal'])
                ->withInput();
        }

        if ($validated['temp_min_critica'] >= $validated['temp_max_critica']) {
            return back()
                ->withErrors(['temp_min_critica' => 'La mediciones mínima crítica debe ser menor que la máxima crítica'])
                ->withInput();
        }

        if ($validated['humedad_min_critica'] >= $validated['humedad_max_critica']) {
            return back()
                ->withErrors(['humedad_min_critica' => 'La humedad mínima crítica debe ser menor que la máxima crítica'])
                ->withInput();
        }

        try {
            $registro->update($validated);

            return redirect()
                ->route('registros_ambientales.index')
                ->with('success', 'Configuración actualizada correctamente');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Error al actualizar la configuración: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Eliminar configuración
     */
    public function destroy($id)
    {
        try {
            RegistroAmbiental::findOrFail($id)->delete();

            return redirect()
                ->route('registros_ambientales.index')
                ->with('success', 'Configuración eliminada correctamente');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Error al eliminar la configuración: ' . $e->getMessage()]);
        }
    }
}
