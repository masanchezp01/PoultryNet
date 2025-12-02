<?php

namespace App\Http\Controllers;

use App\Models\Deteccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeteccionController extends Controller
{
    // Mostrar historial de detecciones del usuario
    public function index()
    {
        $detecciones = Deteccion::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('site.gestion_lotes.lote-detalle', compact('detecciones'));
    }


    // Guardar nueva detección
    public function store(Request $request)
    {
        // ✅ 1. Validar datos del formulario
        $validated = $request->validate([
            'sector_id' => 'required|exists:sectores,id',
            'enfermedad' => 'required|string|max:100',
            'confianza' => 'required|numeric|min:0|max:100',
            'tiempo_deteccion' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'recomendacion' => 'nullable|string',
            'imagen' => 'required|image|mimes:jpeg,png,webp|max:10240', // 10 MB
        ]);

        try {
            // 2. Buscar el último registro ambiental del sector
            $ultimoRegistroAmbiental = \App\Models\RegistroAmbiental::where('sector_id', $validated['sector_id'])
                ->latest('fecha_registro')
                ->first();

            \Log::info('Buscando registro ambiental para sector:', [
                'sector_id' => $validated['sector_id'],
                'encontrado' => $ultimoRegistroAmbiental ? 'SÍ' : 'NO',
                'registro_id' => $ultimoRegistroAmbiental?->id
            ]);

            // 3. Convertir imagen a Base64
            $imagenBase64 = null;
            if ($request->hasFile('imagen')) {
                $imagenFile = $request->file('imagen');
                $imagenContenido = file_get_contents($imagenFile->getRealPath());
                $imagenBase64 = 'data:' . $imagenFile->getMimeType() . ';base64,' . base64_encode($imagenContenido);
            }

            // 4. Crear el registro de detección
            $deteccion = \App\Models\Deteccion::create([
                'user_id' => auth()->id(),
                'sector_id' => $validated['sector_id'],
                'registro_ambiental_id' => $ultimoRegistroAmbiental?->id,
                'imagen_url' => $imagenBase64, // Guardamos la imagen en Base64
                'enfermedad' => $validated['enfermedad'],
                'confianza' => $validated['confianza'],
                'tiempo_deteccion' => $validated['tiempo_deteccion'],
                'observaciones' => $validated['observaciones'] ?? null,
                'recomendacion' => $validated['recomendacion'] ?? null,
            ]);

            \Log::info('Detección creada:', [
                'id' => $deteccion->id,
                'sector_id' => $deteccion->sector_id,
                'registro_ambiental_id' => $deteccion->registro_ambiental_id
            ]);

            // 5. Mensaje de éxito personalizado
            $mensaje = 'Detección registrada correctamente.';
            if ($ultimoRegistroAmbiental) {
                $mensaje .= ' Vinculada con datos ambientales: Temp ' .
                    $ultimoRegistroAmbiental->temperatura . '°C, Humedad ' . $ultimoRegistroAmbiental->humedad . '%.';
            } else {
                $mensaje .= ' No se encontró registro ambiental para vincular.';
            }

            return redirect()
                ->route('site.gestion_lotes.lote-detalle', ['id' => $validated['sector_id']])
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            // Manejo de errores
            \Log::error('Error al guardar detección: ' . $e->getMessage());
            \Log::error('Trace completo:', ['trace' => $e->getTraceAsString()]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar la detección. Por favor, intente nuevamente.');
        }
    }




    // Ver detalle de una detección
    public function show(Deteccion $deteccion)
    {
        return view('detecciones.show', compact('deteccion'));
    }
}
