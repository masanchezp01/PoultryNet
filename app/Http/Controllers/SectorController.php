<?php

namespace App\Http\Controllers;

use App\Models\RegistroAmbiental;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SectorController extends Controller
{

    public function loteDetalle(Sector $sector)
    {
        // Mostrar solo lotes del user logueado
        $lotes = $sector->lotes()
            ->where('user_id', auth()->id())
            ->get();

        // Traer el registro ambiental más reciente del sector
        $registroAmbiental = RegistroAmbiental::where('sector_id', $sector->id)
            ->latest('fecha_registro')
            ->first();

        return view('site.gestion_lotes.lote-detalle', compact('sector', 'lotes', 'registroAmbiental'));
    }


    public function index(Request $request)
    {
        $query = Sector::where('user_id', auth()->id());

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($request->temp == 'low') {
            $query->where('mediciones', '<', 18);
        } elseif ($request->temp == 'normal') {
            $query->whereBetween('mediciones', [18, 25]);
        } elseif ($request->temp == 'high') {
            $query->where('mediciones', '>', 25);
        }

        if ($request->sort == 'recent') {
            $query->latest();
        } elseif ($request->sort == 'oldest') {
            $query->oldest();
        } elseif ($request->sort == 'name') {
            $query->orderBy('nombre', 'asc');
        }

        $sectores = $query->paginate(12)->withQueryString();

        // ✅ Traer Firebase como array
        $firebaseController = new FirebaseController();
        $firebaseData = json_decode(json_encode($firebaseController->getData()->getData()), true);

        return view('site.gestion_sectores.sectores', compact('sectores', 'firebaseData'));
    }


    public function store(Request $request)
    {
        Log::info('Store Sector Request Data', $request->all());

        $request->validate([
            'nombre' => 'required|unique:sectores,nombre',
            'temperatura' => 'required|numeric',
            'descripcion' => 'required|string',
        ], [
            'nombre.unique' => 'El nombre ya existe.',
            'nombre.required' => 'El nombre es obligatorio.',
            'temperatura.required' => 'La temperatura es obligatoria.',
            'temperatura.numeric' => 'La temperatura debe ser un número.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ]);



        $sector = Sector::create([
            'nombre' => $request->nombre,
            'mediciones' => $request->temperatura, // asignar correctamente
            'descripcion' => $request->descripcion,
            'user_id' => auth()->id(),
        ]);

        \Log::info('Sector creado', ['id' => $sector->id, 'nombre' => $sector->nombre]);

        return redirect()->route('sectores.index')
            ->with('success', 'Sector creado correctamente.');
    }



    public function update(Request $request, Sector $sector)
    {
        if ($sector->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('sectores')->ignore($sector->id)->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            'mediciones' => 'required|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $sector->update($request->only('nombre', 'mediciones', 'descripcion'));

        return redirect()->route('sectores.index')
            ->with('success', 'Sector actualizado correctamente.');
    }



    public function destroy(Sector $sector)
    {
        // ✅ asegurar que solo el dueño lo pueda eliminar
        if ($sector->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $sector->delete();

        return redirect()->route('sectores.index')
            ->with('success', 'Sector eliminado correctamente.');
    }
}
