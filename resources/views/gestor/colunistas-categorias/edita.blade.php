@extends('layouts.gestor.app')

@if($categoria->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_categoria_post.colunista'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_categoria_post.colunista'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_categoria_post.colunista')
            @if($categoria->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($categoria->id ? route('gestor.colunistas-categorias.update', $categoria->id) : route('gestor.colunistas-categorias.store')) }}">
    @if($categoria->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_categoria_post.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_categoria" class="form-control-label">@lang('gestor_categoria_post.referencia')</label>
                        <select name="f_categoria" id="f_categoria" class="form-control selectpicker-custom" title="@lang('gestor_categoria_post.referencia')">
                            <option value="">@lang('gestor_categoria_post.referencia')</option>
                            @foreach($s_categorias as $s_categoria)
                            <option value="{{ $s_categoria->id }}"{{ $s_categoria->id == (old('f_categoria') ? old('f_categoria') : $categoria->categoria_id) ? ' selected' : '' }}>{{ $s_categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_ordem" class="form-control-label">@lang('gestor_categoria_post.ordem')</label>
                        <input name="f_ordem" id="f_ordem" type="number" min="0" value="{{ (old('f_ordem') ? old('f_ordem') : $categoria->ordem) }}" class="form-control @error('f_ordem') is-invalid @enderror" placeholder="@lang('gestor_banner.ordem')">
                        @error('f_ordem')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_categoria_post.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $categoria->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_categoria_post.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_categoria_post.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_categoria_post.situacao')">
                            <option value="">@lang('gestor_categoria_post.situacao')</option>
                            @foreach($categoria->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $categoria->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_situacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
