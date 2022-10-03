<div class="col-lg-3 py-2 sidebar-post">
    <div class="infobox p-4">
        <p class="pb-2 text-white h5 bold">@lang('web_blog.top_busca')</p>

        <form action="{{ route('web.agenda.categoria') }}">
            <div class="input-group">
                <input name="f_q" id="f_q" type="search" value="{{ (isset($f_q) ? $f_q : '') }}" class="form-control" placeholder="@lang('web_blog.busca')">
                <div class="input-group-append">
                    <button class="btn" type="submit" style="border:1px solid #FFF;height:46px;"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>

    @if($top->count() > 0)
    <div class="top-viewers">
        <p class="pt-5 pb-2 text-primary h4">@lang('web_blog.top_views')</p>
        <div>
            <div class="list-group list-group-flush">
                @foreach($top->get() as $n =>$s_post)
                <a href="{{ route('web.blog.id', [$s_post->id, Sanitize::string($s_post->nome)]) }}" class="list-group-item list-group-item-action">
                    <small class="text-black"><span class="ordenate-list p-1">{{ ($n+1) }}° </span>{{ $s_post->nome }}</small>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
