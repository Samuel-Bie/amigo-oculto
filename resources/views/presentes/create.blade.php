@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
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
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Informações sobre o presente</div>

                @if (!$evento->isDrawn())
                <div class="card-body">
                    <form action="{{ URL::route('presentes.store', ['evento'=>$evento->chave()]) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" required class="form-control" id="nome" name="nome"
                                placeholder="Ex: Iphone 11 Pro Max">
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control" id="description" rows="3" name="description"
                                placeholder="Detalhes ou observações do presente"></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">
                            Enviar
                        </button>
                    </form>
                </div>

                @else
                <div class="alert alert-danger" role="alert">
                    Este evento ja foi sorteado.
                </div>
                @endif

            </div>
        </div>


    </div>
</div>
@endsection