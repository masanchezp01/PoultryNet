<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Illuminate\Support\Facades\Log;

class FirebaseController extends Controller
{
    protected $auth;
    protected $database;

    public function __construct()
    {
        try {
            $factory = (new Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

            $this->database = $factory->createDatabase();
        } catch (\Throwable $e) {
            // Registrar el error y dejar la propiedad en null para que el resto de la app siga funcionando
            Log::error('Firebase connection failed: ' . $e->getMessage(), ['exception' => $e]);
            $this->database = null;
        }
    }


    public function getData()
    {
        // Si no hay conexión a Firebase, devolver valores por defecto (no lanzar excepción)
        if (is_null($this->database)) {
            return response()->json([
                'luz' => false,
                'sensores' => [],
                'firebase_available' => false,
            ]);
        }

        try {
            // Traer el valor de "luz"
            $luz = $this->database->getReference('luz')->getValue();

            // Traer el valor de "sensores"
            $sensores = $this->database->getReference('sensores')->getValue();

            return response()->json([
                'luz' => $luz,
                'sensores' => $sensores,
                'firebase_available' => true,
            ]);
        } catch (\Throwable $e) {
            Log::error('Firebase getData failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'luz' => false,
                'sensores' => [],
                'firebase_available' => false,
            ]);
        }
    }

    public function toggleLuz(Request $request)
    {
        // Si no hay conexión, informar y regresar al cliente sin lanzar excepción
        if (is_null($this->database)) {
            return redirect()->back()->with('error', 'Servicio de Firebase no disponible.');
        }

        try {
            // Obtener estado actual de la luz
            $luz = $this->database->getReference('luz')->getValue();

            // Convertir a booleano si es necesario
            if ($luz === "true" || $luz === "1" || $luz === 1) {
                $luz = true;
            } elseif ($luz === "false" || $luz === "0" || $luz === 0) {
                $luz = false;
            }

            // Cambiar estado
            $nuevoEstado = !$luz;

            // Actualizar en Firebase
            $this->database->getReference('luz')->set($nuevoEstado);

            // Redirigir de vuelta a la misma vista
            return redirect()->back();

        } catch (\Throwable $e) {
            Log::error('Firebase toggleLuz failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'No se pudo cambiar el estado de la luz.');
        }
    }


}
