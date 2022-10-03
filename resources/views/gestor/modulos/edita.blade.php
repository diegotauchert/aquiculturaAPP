@extends('layouts.gestor.app')

@if($modulo->id)
    @section('title', __('gestor.edicao') . ' - ' . __('gestor_modulo.titulo'))
@else
    @section('title', __('gestor.novo') . ' - ' . __('gestor_modulo.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_modulo.titulo')
            @if($modulo->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($modulo->id ? route('gestor.modulos.update', $modulo->id) : route('gestor.modulos.store')) }}">
    @if($modulo->id)
        @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_modulo.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_modulo.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $modulo->nome) }}" class="form-control @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_modulo.nome')">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_modulo.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_modulo.situacao')">
                            <option value="">@lang('gestor_modulo.situacao')</option>
                            @foreach($modulo->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $modulo->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_situacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_exibe" class="form-control-label">* @lang('gestor_modulo.exibe')</label>
                        <select name="f_exibe" id="f_exibe" class="form-control selectpicker-custom" title="@lang('gestor_modulo.exibe')">
                            <option value="">@lang('gestor_modulo.exibe')</option>
                            @foreach($modulo->present()->makeExibeAll as $exi_k => $exi_v)
                            <option value="{{ $exi_k }}" data-icon="fa-{{ $exi_v[1] }}" {{ $exi_k == (old('f_exibe') ? old('f_exibe') : $modulo->exibe) ? ' selected' : '' }}>{{ $exi_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_exibe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-auto">
                        <label for="f_menu" class="form-control-label">* @lang('gestor_modulo.menu')</label>
                        <select name="f_menu" id="f_menu" class="form-control selectpicker-custom" title="@lang('gestor_modulo.menu')">
                            <option value="">@lang('gestor_modulo.menu')</option>
                            @foreach($modulo->present()->makeMenuAll as $men_k => $men_v)
                            <option value="{{ $men_k }}" data-icon="fa-{{ $men_v[1] }}" {{ $men_k == (old('f_menu') ? old('f_menu') : $modulo->menu) ? ' selected' : '' }}>{{ $men_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_menu')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md">
                        <label for="f_modulo" class="form-control-label">@lang('gestor_modulo.referencia')</label>
                        <select name="f_modulo" id="f_modulo" class="form-control selectpicker-custom" title="@lang('gestor_modulo.referencia')">
                            <option value="">@lang('gestor_modulo.referencia')</option>
                            @foreach($s_modulos as $s_modulo)
                            <option value="{{ $s_modulo->id }}" data-subtext="{{ ($s_modulo->referencia ? $s_modulo->referencia->nome : '') }}"{{ $s_modulo->id == (old('f_modulo') ? old('f_modulo') : $modulo->modulo_id) ? ' selected' : '' }}>{{ $s_modulo->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_modulo.links_modulo')</div>
            <div class="card-body">
                <div id="links" class="clones list-group">
                    @if(old('f_link'))
                        @foreach(old('f_link') as $link_k => $link)
                            @include('gestor.modulos.link')
                        @endforeach
                    @else
                        @foreach($modulo->present()->links as $link_k => $link)
                            @include('gestor.modulos.link')
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 pb-5 text-center">
        <button type="submit" class="btn btn-lg btn-primary"><span class="fas fa-save"></span> @lang('gestor.save')</button>
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::previous() }}"><span class="fas fa-times"></span> @lang('gestor.cancel')</a>
    </div>
</form>
@endsection
