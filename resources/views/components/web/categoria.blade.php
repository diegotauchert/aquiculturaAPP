@php
$subcat_prod = \App\Models\CategoriaProduto::where('situacao', '=', '1')->where('categoria_id', '=' ,$s_categoria->id)->orderBy('ordem', 'ASC')->get();
if($subcat_prod->count() > 0){
    $total_prod_sub = 0;
    foreach($subcat_prod as $sp){
        $total_prod_sub += $sp->produtos->count();
    }
}
@endphp
<li class="nav-item px-xl-2 m-0">
    <a href="{{ route('web.produtos', [$s_categoria->id]) }}"
        class="btn text-primary nav-link border-0 shadow-none @if(isset($categoria) && $s_categoria->id == $categoria->id) active @endif">
        {{ $s_categoria->nome }}
    </a>

    @if($subcat_prod->count() > 0)
    <ul class="nav pl-3 py-2 px-lg-1 py-lg-3">
    @foreach($subcat_prod as $sp)
    <li class="nav-item px-xl-2 m-0">
    <a href="{{ route('web.produtos', [$sp->id]) }}"
        class="btn text-primary nav-link border-0 shadow-none @if(isset($categoria) && $sp->id == $categoria->id) active @endif">
        {{ $sp->nome }}
        ({{ $sp->produtos->count() }})
    </a>
    </li>
    @endforeach
    </ul>
    @endif
</li>
