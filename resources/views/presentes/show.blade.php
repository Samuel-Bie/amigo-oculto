@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Detalhes do gerais</div>
                <div class="card-body">
                    <p>Nome do evento <br />
                        <span class="text-muted pl-1">{{ $evento->nome }}</span>
                    </p>

                    <p>Data de realização<br />
                        <span
                            class="text-muted pl-1">{{ (new Carbon\Carbon($evento->data_realizacao))->format('d-M-Y H:i') }}</span>
                    </p>


                    <p>Dono do presente<br />
                        <span class="text-muted pl-1">{{ $presente->user->name }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detalhes do presente</div>
                <div class="card-body">
                    <p>Nome <br />
                        <span class="text-muted pl-1">{{ $presente->nome }}</span>
                    </p>

                    <p>Detalhes<br />
                        <span class="text-muted pl-1">{{ $presente->detalhes }}</span>
                    </p>
                    @if($presente->isFrom(Auth::user()))


                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#exampleModal">
                        Adicionar fotos
                    </button>

                    @if($evento->nr_presentes_max > Auth::user()->participacaoEm($evento)->presentes()->count() )
                        <a href="{{ URL::route('presentes.create', ['evento'=> $evento->chave()]) }}"
                            class="btn btn-outline-success">Adicionar presente</a>
                    @endif
                    @endif
                    <a href="{{ URL::route('eventos.show', ['evento'=> $evento->chave()]) }}"
                            class="btn btn-outline-warning">Voltar ao evento</a>
                </div>
            </div>

            <div class="card mt-1">
                <div class="card-header">Fotos</div>
                <div class="card-body">
                    @forelse ($presente->fotos as $item)
                    <figure class="figure">
                        <img src="{{ $item->url }}" class="figure-img img-fluid rounded" alt="...">
                        <figcaption class="figure-caption">A caption for the above image.</figcaption>
                    </figure>
                    @empty
                    @if($presente->isFrom(Auth::user()))
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#exampleModal">
                        Adicionar fotos
                    </button>
                    @endif
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@if($presente->isFrom(Auth::user()))
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Carrega as fotos do seu desejo/presente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::route('fotos.store', ['presente' => $presente->chave()]) }}" method="POST"
                    class="dropzone parceiros" enctype="multipart/form-data" id="my-awesome-dropzone"
                    style="border: dashed; border-color: #ccc;">
                    @csrf
                    @method('POST')
                    <div class="fallback">
                        <input type="file" accept="image/*" name="foto" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


@push('script')
<script type="text/javascript">
    Dropzone.autoDiscover = false;
            $(".dropzone.parceiros").dropzone({
                paramName: "foto",
                addRemoveLinks: true,
                acceptedFiles:
                maxFilesize: 2,
                maxFiles:5,
                acceptedFiles:"image/*",
                resizeWidth:500,

                // Mensagens
                dictDefaultMessage: "@lang('Carregue aqui os logotipos dos parceiros').",
                dictFallbackMessage: "@lang('Seu navegador nao suporta este recursor')",
                dictFileTooBig: "@lang('Ficheiro muito grande').",
                dictMaxFilesExceeded: "@lang('Atingiu o limite de ficheiros permitidos')",
                dictInvalidFileType: "@lang('Ficheiro escolhido não é um formato esperado')",
                dictCancelUpload: "@lang('palavras.cancelar')",
                dictUploadCanceled: "@lang('Carregamento cancelado')",
                dictRemoveFile: "Remover",
                dictRemoveFileConfirmation:"@lang('Deseja realmente remover o ficheiro')?",
                removedfile: function(file) {
                    var name = file.name;
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                success: function(response,xhr){
                //    location.reload();
                }
            });
</script>
@endpush

@endif

@endsection