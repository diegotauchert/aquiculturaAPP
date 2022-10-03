@if($anexos->count() > 0)
<div class="col col-md-4 col-lg">
    <div class="row lightgallery-photo">
        @foreach($anexos as $p => $anexo)
        <div class="col-sm col-md-12 col-lg-6 mx-auto my-auto py-2">
            @if($anexo->foto)
            <a href="{{ $anexo->foto->url() }}"><img class="w-100" src="{{ $anexo->foto->url() }}"
                    alt="{{ $anexo->descricao }}"></a>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif
