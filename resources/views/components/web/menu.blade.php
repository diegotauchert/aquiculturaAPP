@php
$menus = \App\Models\Menu::where('link', '=', 'menu-topo')->where('exibe', '=', '2')->get();
@endphp
@if($menus->count() > 0)
@foreach($menus as $menu)
<ul class="nav nav-main">
    <li class="nav-item m-0 text-center">
        <a href="/" title="Voltar para o Início">
            <i class="fas fa-home text-white" style="line-height: 31px;font-size: 14px;"></i>
            <strong class="d-inline d-md-none">Início</strong>
        </a>
    </li>
    @if($menu->itens->count() > 0)
    @foreach($menu->itens->sortBy(function($item) {
    return $item->ordem.'-'.$item->nome;
    }) as $item)
    <li class="nav-item m-0">
        <a href="{{ url(route('web.home') . '/' . $item->link) }}"
            class="btn nav-link border-0 shadow-none text-white bold @if(isset($pagina) && $pagina->link == $item->link) active @endif @if(!isset($pagina) && $item->link == 'home') active @endif"> {{ $item->nome }}
        </a>
    </li>
    @endforeach
    @endif
</ul>

    @php
    $menus = \App\Models\Menu::where('link', '=', 'menu-home')->where('exibe', '=', '2')->get();
    @endphp
    @if($menus->count() > 0)
    <div class="d-block d-md-none">
        <ul class="nav nav-main">
        @foreach($menus as $menu)
            @if($menu->itens->count() > 0)
            @foreach($menu->itens->sortBy(function($item) {
            return $item->ordem.'-'.$item->nome;
            }) as $item)
            <li class="nav-item m-0">
                <a href="{{ url(route('web.home') . '/' . $item->link) }}"
                    class="btn nav-link border-0 shadow-none text-white bold @if(isset($pagina) && $pagina->link == $item->link) active @endif @if(!isset($pagina) && $item->link == 'home') active @endif"> {{ $item->nome }}
                </a>
            </li>
            @endforeach
            @endif

            <li class="nav-item m-0 text-center">
                @if(ModelConfig::find('id_facebook')->valor ?? '')
                <a href="https://www.facebook.com/{{ ModelConfig::find('id_facebook')->valor ?? '' }}/" target="_blank" class="mr-1 btn-social"><i class="fab fa-facebook text-white"></i></a>
                @endif
                @if(ModelConfig::find('id_instagram')->valor ?? '')
                <a href="http://instagram.com/{{ ModelConfig::find('id_instagram')->valor ?? '' }}/" target="_blank" class="mr-1 btn-social"><i class="fab fa-instagram text-white"></i></a>
                @endif
                @if(ModelConfig::find('id_linkedin')->valor ?? '')
                <a href="http://linkedin.com/in/{{ ModelConfig::find('id_linkedin')->valor ?? '' }}/" target="_blank" class="mr-1 btn-social"><i class="fab fa-linkedin text-white"></i></a>
                @endif
                @if(ModelConfig::find('id_twitter')->valor ?? '')
                <a href="https://twitter.com/{{ ModelConfig::find('id_twitter')->valor ?? '' }}/" target="_blank" class="mr-1 btn-social"><i class="fab fa-twitter text-white"></i></a>
                @endif
                @if(ModelConfig::find('id_youtube')->valor ?? '')
                <a href="{{ ModelConfig::find('id_youtube')->valor ?? '' }}/" target="_blank" class="mr-1 btn-social"><i class="fab fa-youtube text-white"></i></a>
                @endif
            </li>
        @endforeach
        </ul>
    </div>
    @endif
@endforeach
@endif
