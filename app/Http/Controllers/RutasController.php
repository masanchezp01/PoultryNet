<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RutasController extends Controller
{
    public function __invoke()
    {
        // valores por defecto por si falla la conexión
        $luz = null;
        $sensores = ['humedad' => null, 'mediciones' => null];

        try {
            // usa el binding del paquete kreait/laravel-firebase
            $database = app('firebase.database');

            $luz = $database->getReference('luz')->getValue();
            $sensores = $database->getReference('sensores')->getValue();
        } catch (\Throwable $e) {
            // guarda el error en log para debug
            Log::error('Firebase DB error: '.$e->getMessage());
        }

        // envía las variables a la vista 'index'
        return view('index', compact('luz', 'sensores'));
    }

    public function mostrarFormularioRegistro()
    {
        return view('auth.registrar');
    }
}
