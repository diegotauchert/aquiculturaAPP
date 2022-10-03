@extends('layouts.gestor.app')

@section('title', __('gestor_config.titulo'))

@section('content')
<div class="row">
    <div class="col-sm my-auto py-2">
        <h1>
            @lang('gestor_config.titulo')
        </h1>
    </div>
</div>
<form method="POST" action="{{ route('gestor.configs.store') }}">
    @csrf
    
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_config.informacoes_seo')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_titulo" class="form-control-label">@lang('gestor_config.seo_titulo')</label>
                        <input name="f_conf[titulo]" id="f_conf_titulo" type="text" class="form-control" placeholder="@lang('gestor_config.seo_titulo')" value="{{ (old('f_conf') && old('f_conf')['titulo'] ? old('f_config')['titulo'] : ($configs->find('titulo')->valor ?? '')) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="f_conf_agendamento" class="form-control-label">Link Externo</label>
                    <input name="f_conf[agendamento]" id="f_conf_agendamento" type="text" class="form-control" placeholder="Informe a url com o http ou https://" value="{{ (old('f_conf') && old('f_conf')['agendamento'] ? old('f_config')['agendamento'] : ($configs->find('agendamento')->valor ?? '')) }}">
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label class="form-control-label">@lang('gestor_config.seo_keywords')</label>
                        <div id="seo_keywords" class="clones list-group">
                            @if(old('f_conf') && old('f_conf')['seo_keyword'])
                                @foreach(old('f_conf')['seo_keyword'] as $seo_keyword_k => $seo_keyword)
                                @include('gestor.configs.seo_keyword')
                                @endforeach
                            @else
                                @if($configs && $configs->find('seo_keyword'))
                                    @foreach($configs->find('seo_keyword')->present()->seoKeywords as $seo_keyword_k => $seo_keyword)
                                    @include('gestor.configs.seo_keyword')
                                    @endforeach
                                @else
                                    @include('gestor.configs.seo_keyword', ['seo_keyword_k' => '', 'seo_keyword' => ''])
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_seo_description" class="form-control-label">@lang('gestor_config.seo_description')</label>
                        <div class="input-group">
                            <textarea name="f_conf[seo_description]" id="f_conf_seo_description" class="form-control maxlength" maxlength="150" placeholder="@lang('gestor_config.seo_description')">{{ (old('f_conf') && old('f_conf')['seo_description'] ? old('f_conf')['seo_description'] : ($configs->find('seo_description')->valor ?? '')) }}</textarea>
                            <div class="input-group-append">
                                <div class="input-group-text content-countdown"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_config.informacoes_contato')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_html_email" class="form-control-label">@lang('gestor_config.html_email')</label>
                        <textarea name="f_conf[html_email]" id="f_conf_html_email" class="form-control tinymce" placeholder="@lang('gestor_config.html_email')">{{ (old('f_conf') && old('f_conf')['html_email'] ? old('f_config')['html_email'] : ($configs->find('html_email')->valor ?? '')) }}</textarea>
                    </div>
                    <div class="form-group col-md">
                        <label for="f_conf_html_telefone" class="form-control-label">@lang('gestor_config.html_telefone')</label>
                        <textarea name="f_conf[html_telefone]" id="f_conf_html_telefone" class="form-control tinymce" placeholder="@lang('gestor_config.html_telefone')">{{ (old('f_conf') && old('f_conf')['html_telefone'] ? old('f_config')['html_telefone'] : ($configs->find('html_telefone')->valor ?? '')) }}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_html_endereco" class="form-control-label">@lang('gestor_config.html_endereco')</label>
                        <textarea name="f_conf[html_endereco]" id="f_conf_html_endereco" class="form-control tinymce" placeholder="@lang('gestor_config.html_endereco')">{{ (old('f_conf') && old('f_conf')['html_endereco'] ? old('f_config')['html_endereco'] : ($configs->find('html_endereco')->valor ?? '')) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_config.rede_social')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_id_facebook" class="form-control-label">@lang('gestor_config.id_facebook')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-facebook-square"></span>
                                </div>
                            </div>
                            <input name="f_conf[id_facebook]" id="f_conf_id_facebook" type="text" class="form-control" placeholder="@lang('gestor_config.id_facebook')" value="{{ (old('f_conf') && old('f_conf')['id_facebook'] ? old('f_config')['id_facebook'] : ($configs->find('id_facebook')->valor ?? '')) }}">
                        </div>
                    </div>
                    <div class="form-group col-md">
                        <label for="f_conf_id_youtube" class="form-control-label">@lang('gestor_config.id_youtube')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-youtube"></span>
                                </div>
                            </div>
                            <input name="f_conf[id_youtube]" id="f_conf_id_youtube" type="text" class="form-control" placeholder="@lang('gestor_config.id_youtube')" value="{{ (old('f_conf') && old('f_conf')['id_youtube'] ? old('f_config')['id_youtube'] : ($configs->find('id_youtube')->valor ?? '')) }}">
                        </div>
                    </div>
                </div>
                {{-- <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_id_twitter" class="form-control-label">@lang('gestor_config.id_twitter')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-twitter"></span>
                                </div>
                            </div>
                            <input name="f_conf[id_twitter]" id="f_conf_id_twitter" type="text" class="form-control" placeholder="@lang('gestor_config.id_twitter')" value="{{ (old('f_conf') && old('f_conf')['id_twitter'] ? old('f_config')['id_twitter'] : ($configs->find('id_twitter')->valor ?? '')) }}">
                        </div>
                    </div>
                    <div class="form-group col-md">
                        <label for="f_conf_id_linkedin" class="form-control-label">@lang('gestor_config.id_linkedin')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-linkedin"></span>
                                </div>
                            </div>
                            <input name="f_conf[id_linkedin]" id="f_conf_id_linkedin" type="text" class="form-control" placeholder="@lang('gestor_config.id_linkedin')" value="{{ (old('f_conf') && old('f_conf')['id_linkedin'] ? old('f_config')['id_linkedin'] : ($configs->find('id_linkedin')->valor ?? '')) }}">
                        </div>
                    </div>
                </div> --}}
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_id_instagram" class="form-control-label">@lang('gestor_config.id_instagram')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-instagram"></span>
                                </div>
                            </div>
                            <input name="f_conf[id_instagram]" id="f_conf_id_instagram" type="text" class="form-control" placeholder="@lang('gestor_config.id_instagram')" value="{{ (old('f_conf') && old('f_conf')['id_instagram'] ? old('f_config')['id_instagram'] : ($configs->find('id_instagram')->valor ?? '')) }}">
                        </div>
                    </div>
                    <div class="form-group col-md">
                        <label for="f_conf_id_whatsapp" class="form-control-label">@lang('gestor_config.id_whatsapp')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-whatsapp"></span>
                                </div>
                            </div>
                            <input name="f_conf[id_whatsapp]" id="f_conf_id_whatsapp" type="text" class="form-control" placeholder="@lang('gestor_config.id_whatsapp')" value="{{ (old('f_conf') && old('f_conf')['id_whatsapp'] ? old('f_config')['id_whatsapp'] : ($configs->find('id_whatsapp')->valor ?? '')) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="card">
            <div class="card-header h5">@lang('gestor_config.outras_informacoes')</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_cod_atendimento" class="form-control-label">@lang('gestor_config.cod_atendimento')</label>
                        <textarea name="f_conf[cod_atendimento]" id="f_conf_cod_atendimento" class="form-control" rows="10" placeholder="@lang('gestor_config.cod_atendimento')">{{ (old('f_conf') && old('f_conf')['cod_atendimento'] ? old('f_config')['cod_atendimento'] : ($configs->find('cod_atendimento')->valor ?? '')) }}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_cod_facebook" class="form-control-label">@lang('gestor_config.cod_facebook')</label>
                        <textarea name="f_conf[cod_facebook]" id="f_conf_cod_facebook" class="form-control" rows="10" placeholder="@lang('gestor_config.cod_facebook')">{{ (old('f_conf') && old('f_conf')['cod_facebook'] ? old('f_config')['cod_facebook'] : ($configs->find('cod_facebook')->valor ?? '')) }}</textarea>
                    </div>
                    <div class="form-group col-md">
                        <label for="f_conf_cod_twitter" class="form-control-label">@lang('gestor_config.cod_twitter')</label>
                        <textarea name="f_conf[cod_twitter]" id="f_conf_cod_twitter" class="form-control" rows="10" placeholder="@lang('gestor_config.cod_twitter')">{{ (old('f_conf') && old('f_conf')['cod_twitter'] ? old('f_config')['cod_twitter'] : ($configs->find('cod_twitter')->valor ?? '')) }}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md">
                        <label for="f_conf_cod_comp_ga" class="form-control-label">@lang('gestor_config.cod_comp_ga')</label>
                        <textarea name="f_conf[cod_comp_ga]" id="f_conf_cod_comp_ga" class="form-control" rows="10" placeholder="@lang('gestor_config.cod_comp_ga')">{{ (old('f_conf') && old('f_conf')['cod_comp_ga'] ? old('f_config')['cod_comp_ga'] : ($configs->find('cod_comp_ga')->valor ?? '')) }}</textarea>
                    </div>
                    <div class="form-group col-md">
                        <label for="f_conf_cod_comp_pixel" class="form-control-label">@lang('gestor_config.cod_comp_pixel')</label>
                        <textarea name="f_conf[cod_comp_pixel]" id="f_conf_cod_comp_pixel" class="form-control" rows="10" placeholder="@lang('gestor_config.cod_comp_pixel')">{{ (old('f_conf') && old('f_conf')['cod_comp_pixel'] ? old('f_config')['cod_comp_pixel'] : ($configs->find('cod_comp_pixel')->valor ?? '')) }}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    
                    <div class="form-group col-md">
                        <label for="f_conf_missao" class="form-control-label">Texto <strong>Quem Somos</strong> Página Inicial (DIREITA)</label>
                        <textarea name="f_conf[missao]" id="f_conf_missao" class="form-control tinymce" rows="10">{{ (old('f_conf') && old('f_conf')['missao'] ? old('f_config')['missao'] : ($configs->find('missao')->valor ?? '')) }}</textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="f_conf_video" class="form-control-label">@lang('gestor_config.video')</label>
                    <input name="f_conf[video]" id="f_conf_video" type="text" class="form-control" placeholder="@lang('gestor_config.p_video')" value="{{ (old('f_conf') && old('f_conf')['video'] ? old('f_config')['video'] : ($configs->find('video')->valor ?? '')) }}">
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


