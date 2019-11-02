<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Presente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenteController extends Controller
{
    // POST	eventos/{evento}/presentes	presentes.store	App\Http\Controllers\PresenteController@
    public function store(Request $request, Evento $evento)
    {
        if (!$evento->isDrawn()) {
            $mySubscription = Auth::user()->participacoes()->whereHas('evento', function ($consulta) use ($evento) {
                $consulta->where('idevento', $evento->chave());
            })->first();


            if ($mySubscription->presentes()->count() == $evento->nr_presentes_max) {
                return redirect()->back()->withErrors([
                    'message' => 'Ja atingio o limite de presentes'
                ])->withInput();
            }
            $presente = new Presente();
            $presente->participacao()->associate($mySubscription);
            $presente->nome = $request->input('nome');
            $presente->detalhes = $request->input('description');
            $presente->save();
            return redirect()->route('presentes.show', ['evento' => $evento->chave(), 'presente' => $presente->chave()]);
        }

        return redirect()->back()->withInput();
    }
    // GET|HEAD	eventos/{evento}/presentes	presentes.index	App\Http\Controllers\PresenteController@
    public function index(Request $request, Evento $evento)
    { }
    // GET|HEAD	eventos/{evento}/presentes/create	presentes.create	App\Http\Controllers\PresenteController@
    public function create(Request $request, Evento $evento)
    {
        $data = compact('evento');
        return view('presentes.create', $data);
    }
    // PUT|PATCH	eventos/{evento}/presentes/{presente}	presentes.update	App\Http\Controllers\PresenteController@
    public function update(Request $request, Evento $evento, Presente $presente)
    { }
    // GET|HEAD	eventos/{evento}/presentes/{presente}	presentes.show	App\Http\Controllers\PresenteController@
    public function show(Request $request, Evento $evento, Presente $presente)
    {

        $data = compact(
            'evento',
            'presente'
        );
        return view('presentes.show', $data);
    }
    // DELETE	eventos/{evento}/presentes/{presente}	presentes.destroy	App\Http\Controllers\PresenteController@
    public function destroy(Request $request, Evento $evento, Presente $presente)
    { }
    // GET|HEAD	eventos/{evento}/presentes/{presente}/edit	presentes.edit	App\Http\Controllers\PresenteController@
    public function edit(Request $request, Evento $evento, Presente $presente)
    { }
}
