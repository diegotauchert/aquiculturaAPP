@foreach($lotes as $key => $lote)
    <div class="batch">
        <h5 class="d-inline m-0">Lote {{$key+1}}</h5>
        <!-- <form method="POST" action="{{ route('gestor.lotes.destroy', $lote->id) }}">
            @method('DELETE')
            @csrf
            <button 
                type="submit" 
                class="confirm btn btn-outline-danger btn-sm float-right" 
                data-toggle="tooltip" 
                data-title="@lang('gestor.confirm_destroy')" 
                title="@lang('gestor.destroy')">
                    <span class="fas fa-trash"></span> 
            </button>
            <br clear="all" />
        </form> -->

        <div class="row">
            <div class="cell">
                <span>Quantidade Atual</span>
                <strong> - </strong>
            </div>
            <div class="cell">
                <span>Quantidade Inicial</span>
                <strong>{{$lote->quantidade}}</strong>
            </div>
            <div class="cell">
                <span>Utilizados</span>
                <strong> - </strong>
            </div>
            <div class="cell">
                <span>Validade</span>
                <strong>{{$lote->validade->format('d/m/Y')}}</strong>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <span>Valor Unitário</span>
                <strong>R$ {{$lote->vl_unitario}}</strong>
            </div>
            <div class="cell">
                <span>Valor Total</span>
                <strong>R$ {{$lote->vl_total}}</strong>
            </div>
            <div class="cell">
                <span>Categoria</span>
                <strong>{{ $produto->present()->getCategoria($lote->categoria_id) }}</strong>
            </div>
            <div class="cell">
                <span>Detalhes</span>
                <p>{{$lote->detalhes}}</p>
            </div>
        </div>
    </div>
    @endforeach