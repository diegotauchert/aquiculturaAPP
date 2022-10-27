@php
$user = new \App\Models\Usuario;
$user->tipo = auth('gestor')->user()->tipo;
@endphp

<li class="dropdown">
    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
    aria-haspopup="false" aria-expanded="false">
        @if(Auth::guard('gestor')->user()->cliente->dt_expira && Auth::guard('gestor')->user()->cliente->externo && Auth::guard('gestor')->user()->cliente->dt_expira >= date("Y-m-d H:i:s"))
        <small class="mr-2 text-danger">
            <i class="fas fa-exclamation-triangle"></i> Seu acesso expira <strong>{{ Carbon\Carbon::parse(Auth::guard('gestor')->user()->cliente->dt_expira)->diffForHumans() }}</strong>
        </small>
        @endif

        @if(Auth::guard('gestor')->user()->fazenda)<small>{{ Auth::guard('gestor')->user()->fazenda->nome }}</small><i class="fa-solid fa-arrow-right mx-2"></i> @endif
        <small class="mr-2">{{ $user->present()->makeTipo[0] }}</small>
        @if(auth('gestor')->user()->foto)
        <img src="{{ auth('gestor')->user()->foto->url(['width' => 200]) }}" alt="{{ auth('gestor')->user()->nome }}" class="rounded-circle" />
        @else
        <img src="{{ asset(mix('images/nouser.jpg')) }}" alt="Sem Imagem" class="rounded-circle" />
        @endif
        
        <span class="ml-1 nav-user-name hidden-sm">
            @auth('gestor')
            {{ Auth::guard('gestor')->user()->present()->apelido  }}
            @endauth
            <i class="mdi mdi-chevron-down"></i>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item @if (Route::currentRouteName() == 'gestor.editar-perfil') active @endif" href="{{ route('gestor.editar-perfil') }}"><i class="dripicons-user text-muted mr-2"></i> @lang('gestor_perfil.subtitulo')</a>
        <a class="dropdown-item @if (Route::currentRouteName() == 'gestor.mudar-senha') active @endif" href="{{ route('gestor.mudar-senha') }}"><i class="dripicons-gear text-muted mr-2"></i> @lang('gestor_senha.subtitulo')</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item confirm" href="{{ route('gestor.logout') }}" data-title="@lang('gestor.confirm_logout')"><i class="dripicons-exit text-muted mr-2"></i> @lang('gestor_dashboard.sair')</a>
    </div>
</li>
