@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Detalhes do evento</div>
                <div class="card-body">
                    <p>Nome <br />
                        <span class="text-muted pl-1">{{ $evento->nome }}</span>
                    </p>

                    <p>Nº máximo de Presentes<br />
                        <span class="text-muted pl-1">{{ $evento->nr_presentes_max }}</span>
                    </p>

                    <p>Valor mínimo<br />
                        <span class="text-muted pl-1">{{ number_format ( $evento->valor_min , 2 ) }}</span>
                    </p>

                    <p>Data de realização<br />
                        <span
                            class="text-muted pl-1">{{ (new Carbon\Carbon($evento->data_realizacao))->format('d-M-Y H:i') }}</span>
                    </p>


                    <p>Nº de participantes inscritos<br />
                        <span class="text-muted pl-1">{{ $evento->nrParticipantes() }}</span>
                    </p>

                    <p>Data de sorteio<br />
                        <span
                            class="text-muted pl-1">{{ (new Carbon\Carbon($evento->data_sorteio))->format('d-M-Y H:i') }}</span>
                    </p>



                    @if(Auth::user()->admin)

                    @if(!$evento->isDrawn())
                    <p>
                        <a href="{{ URL::route('evento.draw', ['evento' => $evento->chave()]) }}"
                            class="btn btn-outline-danger">Sortear</a>
                    </p>
                    @endif
                    @endif



                </div>
            </div>
        </div>


        <div class="col-md-8">

            @if ($evento->isSubscribed(Auth::user()))


            @if ($evento->isDrawn())

            <div class="card">
                <div class="card-header">Informacoes do amigo</div>
                <div class="card-body">
                    <p>Nome <br />
                        <span class="text-muted pl-1">{{ $mySubscription->amigo->user->name }}</span>
                    </p>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">Presentes/desejos de {{ $mySubscription->amigo->user->name }}</div>


                <div class="card-body">
                    @if ($mySubscription->amigo->user->participacaoEm($evento)->presentes()->exists())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Detalhes</th>
                                <th scope="col">Fotos</th>
                            </tr>
                        </thead>


                        <tbody>
                            @forelse ($mySubscription->amigo->user->participacaoEm($evento)->presentes as $presente)

                            <tr>
                                <td>{{ $presente->nome }}</td>
                                <td>{{ $presente->detalhes }}</td>
                                <td>
                                    <a href="{{ URL::route('presentes.show', ['evento'=> $evento->chave(), 'presente'=>$presente->chave()]) }}"
                                        class="btn btn-sm
                                        btn-outline-info"> Ver fotos</a>
                                </td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <p>Sem presentes</p>
                    @endif
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">Participação confirmada</div>
                <div class="card-body">
                    <a class="btn btn-outline-danger"
                        href="{{ URL::route('eventos.unsubscribe', ['evento' => $evento->chave()]) }}">Cancelar</a>
                </div>
            </div>

            <div class="card mt-2">


                <div class="card-header">Meus presentes/desejos</div>


                    @if($evento->nr_presentes_max > $mySubscription->presentes()->count() )
                    <div class="m-2">

                            <a href="{{ URL::route('presentes.create', ['evento'=> $evento->chave()]) }}"
                                    class="btn btn-outline-primary">Adicionar</a>
                    </div>

                    @endif



                    @if ($mySubscription->presentes()->exists())
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Detalhes</th>
                                <th scope="col">Fotos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mySubscription->presentes as $presente)

                            <tr>
                                <td>{{ $presente->nome }}</td>
                                <td>{{ $presente->detalhes }}</td>
                                <td>
                                    <a href="{{ URL::route('presentes.show', ['evento'=> $evento->chave(), 'presente'=>$presente->chave()]) }}"
                                        class="btn btn-sm
                                        btn-outline-info"> Ver fotos</a>
                                </td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <p>Sem presentes</p>

                    @endif
                </div>
            </div>
            @endif

            @else

            <div class="card">
                <div class="card-header">Não confirmou sua participacao no evento</div>
                <div class="card-body">
                    <a href="{{ URL::route('eventos.subscribe', ['evento'=> $evento->chave()]) }}"
                        class="btn btn-outline-primary">Confirmar</a>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection