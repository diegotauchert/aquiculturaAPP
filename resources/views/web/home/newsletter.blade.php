<div class="text-black pb-4" id="newsletter">
    <div class="newsletter-box container-fluid p-4">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 pt-4 text-right">
                <p>@lang('web.news_deseja')</p>
                <h5 class="m-0">@lang('web.news_cadastre')</h5>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 py-3">
                <form method="POST" action="{{ route('web.interessado.create') }}">
                    @csrf
                    @if (session('alert'))
                    @web_alert(['type' => session('alert')['type']])
                    {!! session('alert')['message'] !!}
                    @endweb_alert
                    @endif
                    <div class="form-row pr-md-4">
                        <div class="form-group col-md my-auto py-2">
                            <input name="f_nome" id="f_nome"
                                class="form-control form-control-lg @error('f_nome') is-invalid @enderror" type="text"
                                value="{{ old('f_nome') }}" placeholder="@lang('web_contato.nome')">
                            @error('f_nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md my-auto py-2">
                            <input name="f_email" id="f_email"
                                class="form-control form-control-lg @error('f_email') is-invalid @enderror" type="email"
                                value="{{ old('f_email') }}" placeholder="@lang('web_contato.email')">
                            @error('f_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-auto my-auto py-2 pr-4 mr-3">
                            <button class="btn-main btn-small" type="submit"><i class="fas fa-envelope"></i>
                                @lang('web.inscrever')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
