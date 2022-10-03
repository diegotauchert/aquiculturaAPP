@php
$menus = \App\Models\Menu::where('link', '=', 'menu-base')->where('exibe', '=', '2')->get();
@endphp
@if($menus->count() > 0)
@foreach($menus as $menu)
<div class="row">
    <div class="col-md-6">
        @if($menu->itens->count() > 0)
        @php
        $c = 0;
        @endphp
        @foreach($menu->itens->sortBy(function($item) {
        return $item->ordem.'-'.$item->nome;
        }) as $item)
        @php
        $c++;
        @endphp
        <a href="{{ url(route('web.home') . '/' . $item->link) }}" class="btn btn-block text-left btn-outline-light border-0 @if(isset($pagina) && $pagina->link == $item->link) active @endif @if(!isset($pagina) && $item->link == 'home') active @endif">{{ $item->nome }}</a>

        @if($c == ceil($menu->itens->count() / 2))
    </div>
    <div class="col-md-6">
        @endif


        @endforeach
        @endif
    </div>
</div>
@endforeach
@endif
