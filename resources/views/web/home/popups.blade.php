@if($popups->count() > 0)
@foreach($popups->get() as $k => $popup)
@if($popup->texto || $popup->arquivo)
<div class="modal popup fade" id="popup{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="popupTitle{{ $k }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered @if($popup->arquivo) modal-lg @endif" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupTitle{{ $k }}">{{ $popup->nome }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('web.fechar')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if($popup->arquivo)
            <div class="position-relative">
                @if($popup->arquivo)
                <img class="w-100 d-none d-lg-block @if(!$popup->texto) rounded-bottom @endif border" src="{{ $popup->arquivo->url() }}" alt="{{ $popup->nome }}">
                @endif
                @if($popup->responsivo)
                <img class="w-100 d-block d-lg-none @if(!$popup->texto) rounded-bottom @endif border" src="{{ $popup->responsivo->url() }}" alt="{{ $popup->nome }}">
                @endif
                @if($popup->link)
                <a href="{{ $popup->link }}" {{ $popup->present()->alvo }} class="stretched-link w-100"></a>
                @endif
            </div>
            @endif
            @if($popup->texto)
            <div class="modal-body">
                {!! $popup->texto !!}
                @if($popup->link)
                <p class="pt-2"><a href="{{ $popup->link }}" {{ $popup->present()->alvo }} class="btn btn-primary stretched-link"><span class="fas fa-plus"></span> @lang('web.ver_mais')</a></p>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endif
@endforeach
@endif
