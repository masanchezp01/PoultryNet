<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;

class FirebaseController extends Controller
{
    protected $auth;
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->database = $factory->createDatabase();
    }


    public function getData()
    {
        // Traer el valor de "luz"
        $luz = $this->database->getReference('luz')->getValue();

        // Traer el valor de "sensores"
        $sensores = $this->database->getReference('sensores')->getValue();

        return response()->json([
            'luz' => $luz,
            'sensores' => $sensores,
        ]);
    }

    public function toggleLuz(Request $request)
    {
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

        } catch (\Exception $e) {
            // Redirigir con mensaje de error (opcional)
            return redirect()->back()->with('error', 'No se pudo cambiar el estado de la luz.');
        }
    }


}
