<li class="hidden-sm">
    <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript: void(0);" role="button"
        aria-haspopup="false" aria-expanded="false">
        {{ session()->get('lang')->nome }}
        <img src="/images/{{ session()->get('lang')->sigla }}.jpg" class="ml-2" height="16" alt="{{ session()->get('lang')->nome }}"/>
        <i class="mdi mdi-chevron-down"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        @foreach (Config::get('languages') as $lang => $language)
        <a class="dropdown-item @if ($lang == session()->get('lang')->sigla) active @endif" href="{{ route('gestor.lang.switch', $lang) }}">
            <img src="/images/{{ $lang }}.jpg" alt="{{ $language }}" class="ml-2 float-right" height="14" title="{{ $language }}"/>
            <span> {{ $language }} </span>
        </a>
        @endforeach
    </div>
</li>
