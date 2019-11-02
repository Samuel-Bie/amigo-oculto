@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Eventos Futuros</div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($eventosFuturos as $evento)
                        <a href="{{ URL::route('eventos.show', ['evento'=>$evento->chave()]) }}"
                            class="list-group-item list-group-item-action {!! $evento->isFuture()? 'active':'' !!} ">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"> {{ $evento->nome }}</h5>
                                <small>{{ (new Carbon\Carbon($evento->data_realizacao))->format('Y-M-d') }}</small>
                            </div>
                            <small>{{ $evento->participacoes()->count() }} Participantes</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Eventos que vou participar</div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($meusEventosFuturos as $evento)
                        @php
                        $evento = $evento->evento;
                        @endphp
                        <a href="{{ URL::route('eventos.show', ['evento'=>$evento->chave()]) }}"
                            class="list-group-item list-group-item-action {!! $evento->isFuture()? 'active':'' !!} ">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"> {{ $evento->nome }}</h5>
                                <small>{{ (new Carbon\Carbon($evento->data_realizacao))->format('Y-M-d') }}</small>
                            </div>
                            <small>{{ $evento->participacoes()->count() }} Participantes</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Eventos que participei</div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($meusEventosPassados as $evento)
                        @php
                        $evento = $evento->evento;
                        @endphp
                        <a href="{{ URL::route('eventos.show', ['evento'=>$evento->chave()]) }}"
                            class="list-group-item list-group-item-action {!! $evento->isFuture()? 'active':'' !!} ">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"> {{ $evento->nome }}</h5>
                                <small>{{ (new Carbon\Carbon($evento->data_realizacao))->format('Y-M-d') }}</small>
                            </div>
                            <small>{{ $evento->participacoes()->count() }} Participantes</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection