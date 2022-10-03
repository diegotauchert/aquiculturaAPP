@php
$menus = \App\Models\Menu::where('link', '=', 'menu-rodape')->where('exibe', '=', '2')->get();
@endphp
@if($menus->count() > 0)
@foreach($menus as $menu)
<ul class="nav-footer d-inline-block text-left m-0 p-0">
    @if($menu->itens->count() > 0)
    @foreach($menu->itens->sortBy(function($item) {
    return $item->ordem.'-'.$item->nome;
    }) as $item)
    <li class="nav-item m-0">
        <a 
            href="{{ url(route('web.home') . '/' . $item->link) }}"
            class="@if(isset($pagina) && $pagina->link == $item->link) active @endif @if(!isset($pagina) && $item->link == 'home') active @endif">
            {{ $item->nome }}
        </a>
    </li>
    @endforeach
    @endif
</ul>
@endforeach
@endif
