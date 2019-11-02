<?php

namespace App\Http\Controllers;

use App\Amigo;
use App\Evento;
use App\Participacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{

    // POST	eventos.store
    public function store(Request $request)
    { }
    // GET|HEAD	eventos.index
    public function index()
    {
        return redirect()->route('home');
    }
    // GET|HEAD	eventos.create
    public function create()
    { }
    // DELETE	eventos/{evento}	eventos.destroy
    public function destroy(Evento $evento)
    { }
    // PUT|PATCH	eventos/{evento}	eventos.update
    public function update(Evento $evento, Request $request)
    { }
    // GET|HEAD	eventos/{evento}	eventos.show
    public function show(Evento $evento)
    {

        $mySubscription = Auth::user()->participacaoEm($evento);
        $data = compact('evento', 'mySubscription');
        return view('eventos.show', $data);
    }
    // GET|HEAD	eventos/{evento}/edit	eventos.edit
    public function edit(Evento $evento)
    { }


    public function draw(Evento $evento)
    {
        if ($evento->isDrawn())
            return redirect()->back()->withErrors([
                'message' => 'Evento ja foi sorteado'
            ])->withInput();

        $test = $evento->participacoes()->doesntHave('amigo')->exists();
        while ($test) {
            $this->match($evento);
            $test = $evento->participacoes()->doesntHave('amigo')->exists();
        }
        $evento->drawn = true;
        $evento->save();
        return redirect()->back();
    }

    public function match(Evento $evento)
    {

        $participantes = $evento->participacoes()
            ->doesntHave('amigo')
            ->inRandomOrder()
            ->get()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle();

        $participantes1 = $evento->participacoes()
            ->inRandomOrder()
            ->get()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle()
            ->shuffle();

        foreach ($participantes as $participacao) {
            if($participacao->amigo()->exists())
                continue;


            $part  = $participantes1->pop();

            if ($participacao->is($part))
                continue;


            if ((new Participacao())->whereHas('amigo', function ($consulta) use ($part) {
                $consulta->where('users_id', $part->user->id);
            })->exists())
                continue;

            $amigo = new Amigo();
            $amigo->participacao()->associate($participacao);
            $amigo->user()->associate($part->user);
            $amigo->save();
        }

        return;
    }

    public function subscribe(Evento $evento)
    {
        if (!$evento->isSubscribed(Auth::user())) {
            $participacao = new Participacao();
            $participacao->evento()->associate($evento);
            $participacao->user()->associate(Auth::user());
            $participacao->save();
        }
        return redirect()->back();
    }

    public function unsubscribe(Evento $evento)
    {
        if ($evento->isSubscribed(Auth::user())) {
            $evento->participacoes()->whereHas('user', function ($consulta) {
                $consulta->where('id', Auth::user()->id);
            })->forceDelete();
        }
        return redirect()->back();
    }
}
