@permissao('gestor', 'gestor.interessados.index')
<div class="card my-2">
    <div class="card-header h4">@lang('gestor_dashboard.interessados-novos')</div>
    @if(count($interessados) > 0)
    <div class="list-group list-group-flush">
        @foreach($interessados as $interessado)
        <div class="list-group-item list-group-item-action list-group-item-{{ $interessado->present()->color }} d-flex">
            <div class="w-100 align-self-center">
                <a href="#" data-toggle="modal" data-target="#mod-interessado-{{ $interessado->id }}" class="h6 font-weight-bold text-reset stretched-link">{{ $interessado->nome }}</a>
            </div>
            @if($interessado->created_at)
            <small class="w-100 text-right align-self-center">
                @if($interessado->colaborador)
                @if($interessado->colaborador)
                <span class="fas fa-user"></span> <b>{{ $interessado->colaborador->pessoa->present()->makeApelido }}</b><br><br>
                @endif
                @endif
                <span class="fas fa-calendar-alt"></span> {{ $interessado->created_at->format('d/m/Y') }}<br>
                <span class="fas fa-clock"></span> {{ $interessado->created_at->format('H:i')}}
            </small>
            @endif
        </div>
        @endforeach
    </div>
    <div class="card-footer">
        {{ $interessados->onEachSide(1)->links('vendor.pagination.bootstrap-4-min') }}
    </div>
    @else
    <div class="card-body">
        <p class="h5 text-center py-5">@lang('gestor.no_data')</p>
    </div>
    @endif
    @foreach($interessados as $interessado)
    <div class="modal fade" id="mod-interessado-{{ $interessado->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title h5" id="exampleModalLabel">{{ $interessado->nome }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="@lang('gestor.close')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($interessado->created_at)
                    <p class="h6 row">
                        <span class="col-auto">
                            <span class="fas fa-calendar-alt"></span>
                            {{ $interessado->created_at->format('d/m/Y') }}
                        </span>
                        <span class="col-auto">
                            <span class="fas fa-clock"></span>
                            {{ $interessado->created_at->format('H:i') }}
                        </span>
                        @if($interessado->colaborador)
                        @if($interessado->colaborador)
                        <span class="col-auto ml-auto">
                            <span class="fas fa-user"></span> <b>{{ $interessado->colaborador->pessoa->present()->makeApelido }}</b>
                        </span>
                        @endif
                        @endif
                    </p>
                    @endif

                    @if(count($interessado->telefones) > 0)
                    @foreach($interessado->telefones as $telefone)
                    <button class="btn btn-outline-dark border-0 copy" data-clipboard-text="{{ $telefone->numero }}">{{ $telefone->numero }}</button><br>
                    @endforeach
                    @endif
                    @if(count($interessado->emails) > 0)
                    @foreach($interessado->emails as $email)
                    <a href="mailto:{{ $email->email }}" class="btn btn-outline-dark border-0">{{ $email->email }}</a><br>
                    @endforeach
                    @endif
                    @if(count($interessado->cursos) > 0)
                    <br>
                    @foreach($interessado->cursos as $curso)
                    {{ ($curso->curso ? $curso->curso->nome : '') }}<br>
                    @endforeach
                    @endif
                    <br>
                    {!! nl2br($interessado->obs) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fas fa-times"></span> @lang('gestor.close')</button>

                    @permissao('gestor', 'gestor.interessados.edit')
                    <a href="{{ route('gestor.interessados.edit', $interessado->id) }}" class="btn btn-outline-primary"><span class="fas fa-pen"></span> @lang('gestor.edit')</a>
                    @endpermissao
                    @permissao('gestor', 'gestor.relacionamentos.create')
                    <a href="{{ route('gestor.relacionamentos.create', ['interessado' => $interessado->id]) }}" class="btn btn-primary"><span class="fas fa-asterisk"></span> @lang('gestor_relacionamento.create')</a>
                    @endpermissao
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endpermissao
