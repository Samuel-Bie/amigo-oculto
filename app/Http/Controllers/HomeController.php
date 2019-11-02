<?php

namespace App\Http\Controllers;

use App\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $eventosFuturos = Evento::futuros();

        $meusEventosPassados = Auth::user()->participacoes()->whereHas('evento', function ($query) {
            $query->whereDate('data_realizacao', '<', now());
        })->get();

        $meusEventosFuturos = Auth::user()->participacoes()->whereHas('evento', function ($query) {
            $query->whereDate('data_realizacao', '>=', now());
        })->get();

        $data = compact(
            'eventosFuturos',
            'meusEventosPassados',
            'meusEventosFuturos'
        );


        return view('home', $data);
    }
}
