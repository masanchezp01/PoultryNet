<?php

namespace App\Http\Controllers;

use App\Models\PreguntaSatisfaccion;
use Illuminate\Http\Request;

class GraficoSatisfaccionController extends Controller
{
    public function index()
    {
        // Cargamos todas las preguntas con sus respuestas y el usuario que respondió
        $preguntas = PreguntaSatisfaccion::with(['respuestas.user'])->get();

        return view('site.grafico_form.index', compact('preguntas'));
    }

}
