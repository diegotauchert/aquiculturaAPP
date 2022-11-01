@foreach($lotes as $key => $lote)
    <div class="batch">
        <h4 class="mx-2 my-1 text-uppercase"><i class="fas fa-weight-hanging"></i> <small>Lote</small> {{$key+1}}</h4>
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
            <!-- <div class="cell">
                <span>Quantidade Atual</span>
                <strong> - </strong>
            </div> -->
            <div class="cell">
                <span><i class="fas fa-weight-hanging"></i> Quantidade</span>
                <strong>{{$lote->quantidade}}</strong>
            </div>
            <!-- <div class="cell">
                <span>Utilizados</span>
                <strong> - </strong>
            </div> -->
            <div class="cell">
                <span><i class="fas fa-calendar-alt"></i> Validade</span>
                <strong>{{$lote->validade->format('d/m/Y')}}</strong>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <span><i class="fas fa-money-bill-wave"></i> Valor Unitário</span>
                <strong class="nowrap">R$ {{$lote->vl_unitario}}</strong>
            </div>
            <div class="cell">
                <span><i class="fas fa-coins"></i> Valor Total</span>
                <strong class="nowrap">R$ {{$lote->vl_total}}</strong>
            </div>
            <div class="cell">
                <span><i class="fas fa-box-open"></i> Categoria</span>
                <strong>{{ $produto->present()->getCategoria($lote->categoria_id) }}</strong>
            </div>
            <!-- <div class="cell">
                <span>Detalhes</span>
                <p>{{$lote->detalhes}}</p>
            </div> -->
        </div>
    </div>
    @endforeach