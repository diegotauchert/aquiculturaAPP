@php
$k = 4;
$icons = [
    0 => 'gear',
    1 => 'flag',
    2 => 'view-thumb',
    3 => 'user-group'
]

@endphp

@if(\App\Models\Modulo::select('modulos.*')->leftJoin('permissoes', 'permissoes.modulo_id', '=', 'modulos.id')->where('permissoes.usuario_id', '=', Auth::guard('gestor')->user()->id)->where('modulos.situacao', '=', '1')->where('modulos.menu', '=', $k)->where('modulos.exibe', '=', '1')->whereNull('modulos.modulo_id')->whereNull('permissoes.deleted_at')->orderBy('modulos.nome', 'asc')->count() > 0)
    @foreach(\App\Models\Modulo::select('modulos.*')->leftJoin('permissoes', 'permissoes.modulo_id', '=', 'modulos.id')->where('permissoes.usuario_id', '=', Auth::guard('gestor')->user()->id)->where('modulos.situacao', '=', '1')->where('modulos.menu', '=', $k)->where('modulos.exibe', '=', '1')->whereNull('modulos.modulo_id')->whereNull('permissoes.deleted_at')->orderBy('modulos.nome', 'asc')->get() as $key => $submenu)
        @if($submenu->exibe == 1)
        <li class="nav-item">
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
            ) }}" class="nav-link {{ (in_array(Route::currentRouteName(), $submenu->present()->links) ? ' active' : '') }}">
            <i class="dripicons-{{ $icons[$key] }}"></i>
            {{ $submenu->nome }}
        </a>
        </li>
        @endif
    @endforeach
@endif

