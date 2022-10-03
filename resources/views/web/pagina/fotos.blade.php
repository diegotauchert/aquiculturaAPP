@if($anexos->count() > 0)
<div class="row lightgallery-photo" role="listbox">
    @php
    $k = 0;
    @endphp
    @foreach($anexos as $anexo)
    <div class="col-md-6">
        <div class="card photo m-0 mb-4 @if($k == 0) active @endif" style="margin-left: auto;margin-right: auto;">
            @if($anexo->foto)
            <a href="{{ $anexo->foto->url() }}" class="card-body p-2" title="{{ $anexo->descricao }}" datta-toglle="tooltip">
                <img class="d-block mx-auto w-100" src="{{ $anexo->foto->url(['w'=>400]) }}" alt="{{ $anexo->descricao }}" style="max-height:250px;" />
            </a>
            @endif
        </div>
        @php
        $k++;
        @endphp
    </div>
    @endforeach
</div>
@endif
