@extends('layouts.gestor.app')

@if($menu->id)
@section('title', __('gestor.edicao') . ' - ' . __('gestor_menu.titulo'))
@else
@section('title', __('gestor.novo') . ' - ' . __('gestor_menu.titulo'))
@endif

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_menu.titulo')
            @if($menu->id)
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.edicao')</small>
            @else
            <small class="text-secondary d-block d-md-inline-block">\ @lang('gestor.novo')</small>
            @endif
        </h1>
    </div>
</div>
<form method="POST" action="{{ ($menu->id ? route('gestor.menus.update', $menu->id) : route('gestor.menus.store')) }}">
    @if($menu->id)
    @method('PUT')
    @endif

    @csrf

    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_menu.informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_menu" class="form-control-label">@lang('gestor_menu.referencia')</label>
                        <select name="f_menu" id="f_menu" class="form-control selectpicker-custom" title="@lang('gestor_menu.referencia')">
                            <option value="">@lang('gestor_menu.referencia')</option>
                            @foreach($s_menus as $s_menu)
                            <option value="{{ $s_menu->id }}"{{ $s_menu->id == (old('f_menu') ? old('f_menu') : $menu->menu_id) ? ' selected' : '' }}>{{ $s_menu->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_nome" class="form-control-label">* @lang('gestor_menu.nome')</label>
                        <input name="f_nome" id="f_nome" type="text" value="{{ (old('f_nome') ? old('f_nome') : $menu->nome) }}" class="form-control normatize @error('f_nome') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_menu.nome')" data-ref="f_link">
                        @error('f_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_link" class="form-control-label">* @lang('gestor_menu.link')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ url('') . '/' }}</div>
                            </div>
                            <input name="f_link" id="f_link" type="text" value="{{ (old('f_link') ? old('f_link') : $menu->link) }}" class="form-control bg-light text-dark normatize @error('f_link') is-invalid @enderror" maxlength="250" placeholder="@lang('gestor_menu.link')" data-ref="f_link">
                        </div>
                        @error('f_link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-auto">
                        <label for="f_ordem" class="form-control-label">@lang('gestor_menu.ordem')</label>
                        <input name="f_ordem" id="f_ordem" type="text" value="{{ (old('f_ordem') ? old('f_ordem') : $menu->ordem) }}" class="form-control" maxlength="250" placeholder="@lang('gestor_menu.ordem')">
                    </div>

                    <div class="form-group col-md-auto">
                        <label for="f_exibe" class="form-control-label">* @lang('gestor_menu.exibe')</label>
                        <select name="f_exibe" id="f_exibe" class="form-control selectpicker-custom" title="@lang('gestor_menu.exibe')">
                            <option value="">@lang('gestor_menu.exibe')</option>
                            @foreach($menu->present()->makeExibeAll as $exi_k => $exi_v)
                            <option value="{{ $exi_k }}" data-icon="fa-{{ $exi_v[1] }}" {{ $exi_k == (old('f_exibe') ? old('f_exibe') : $menu->exibe) ? ' selected' : '' }}>{{ $exi_v[0] }}</option>
                            @endforeach
                        </select>
                        @error('f_exibe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-auto">
                        <label for="f_situacao" class="form-control-label">* @lang('gestor_menu.situacao')</label>
                        <select name="f_situacao" id="f_situacao" class="form-control selectpicker-custom" title="@lang('gestor_menu.situacao')">
                            <option value="">@lang('gestor_menu.situacao')</option>
                            @foreach($menu->present()->makeSituacaoAll as $sit_k => $sit_v)
                            <option value="{{ $sit_k }}" data-icon="fa-{{ $sit_v[1] }}" {{ $sit_k == (old('f_situacao') ? old('f_situacao') : $menu->situacao) ? ' selected' : '' }}>{{ $sit_v[0] }}</option>
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
