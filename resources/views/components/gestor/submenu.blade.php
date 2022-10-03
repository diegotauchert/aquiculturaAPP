@if($submenu->exibe == 1)
<li>
    <a href="{{ (
                (
                $submenu->exibe == 1 ?
        Route::has(
            count($submenu->present()->links) > 0 ? 
                $submenu->present()->links[0] : 
                $submenu->link
        ) ? 
            route(
                count($submenu->present()->links) > 0 ? 
                    $submenu->present()->links[0] : 
                    $submenu->link
            ) : 
            ''
            : '')
    ) }}" class="nav-link {{ (in_array(Route::currentRouteName(), $submenu->present()->links) ? ' active' : '') }}"><i class="dripicons-paperclip"></i> {{ $submenu->nome }}</a>
    <ul class="shadow">
        @foreach($submenu->modulos->where('situacao', '=', '1')->sortBy('nome') as $submenu)
        @include('components.gestor.submenu')
        @endforeach
    </ul>
</li>
@else
    @if(in_array(Route::currentRouteName(), $submenu->present()->links))
    <li class="d-none"><a class="dropdown-item active"></a></li>
    @endif
@endif
