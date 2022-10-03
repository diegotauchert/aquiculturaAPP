@extends('layouts.gestor.print')

@section('title', __('gestor_curriculo.titulo'))

@section('content')

<style>
    *{
        font-family: 'Arial', sans-serif;
    }
    @page {
        margin: 20px 40px 75px 40px;
    }
    p{
        font-size: 12px;
    }
    strong{
        font-size: 10px;
    }
</style>
<title>test title</title>
<header>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                @if($curriculo->foto)
                <div style="border:1px solid #EEE; padding:5px;display:inline-block;">
                <img src="{{ str_replace('public','storage/app/public/curriculos',public_path($curriculo->foto->name())) }}" width="130px">
                </div>
                @endif
            </td>
            <td colspan="2">
                <h6 style="text-align: right;">Nº {{ $curriculo->id }}</h6>
                <h5><small>CURRICULO</small> <span style="font-size: 1.3rem;">{{ strtoupper($curriculo->nome) }}<span></h5>
                <p>
                    @if($curriculo->email)
                    <strong>EMAIL:</strong> {{ $curriculo->email }}
                    @endif
                    @if($curriculo->telefone)
                    <strong>TELEFONE:</strong> {{ $curriculo->telefone }}
                    @endif
                </p>
                <p>
                    @if($curriculo->cpf)
                    <strong>CPF:</strong> {{ $curriculo->cpf }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                    @if($curriculo->rg)
                    <strong>RG:</strong> {{ $curriculo->rg }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                    @if($curriculo->nascimento)
                    <strong>DATA DE NASCIMENTO:</strong> @date($curriculo->nascimento)
                    @endif
                </p>

                @if($curriculo->estado_civil)
                <p>
                <strong>ESTADO CÍVIL:</strong> {{ mb_strtoupper($curriculo->present()->makeEstadoCivil) }}
                </p>
                @endif
                @if($curriculo->sexo)
                <p>
                <strong>Sexo:</strong> {{ mb_strtoupper($curriculo->present()->makeSexo) }}
                </p>
                @endif

                <p>
                    @if($curriculo->endereco)
                    <strong>ENDEREÇO:</strong> {{ $curriculo->endereco }}
                    @endif
                    @if($curriculo->bairro)
                    <strong>BAIRRO:</strong> {{ $curriculo->bairro }}
                    @endif
                    @if($curriculo->numero)
                    <strong>Nº:</strong> {{ $curriculo->numero }}
                    @endif
                    @if($curriculo->complemento)
                    <strong>COMPLEMENTO:</strong> {{ $curriculo->complemento }}
                    @endif
                    @if($curriculo->cidade)
                    <strong>CIDADE:</strong> {{ $curriculo->cidade->nome }}
                    @endif
                    @if($curriculo->cidade->estado)
                    <strong>ESTADO:</strong> {{ $curriculo->cidade->estado->nome }}
                    @endif
                    @if($curriculo->cep)
                    <strong>CEP:</strong> {{ $curriculo->cep }}
                    @endif
                </p>
            </td>
        </tr>
    </table>
</header>
<main>
    <p>&nbsp;</p>
    <table width="100%" cellpadding="0" cellspacing="0" class="border">
        <tr>
            <td>
                <p><b>INFORMAÇÕES PROFISSIONAIS</b></p>
                <p>
                    @if($curriculo->cargo)
                    <strong>Cargo atual ou último cargo ocupado:</strong> {{ $curriculo->cargo }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                    @if($curriculo->formacao)
                    <strong>Formação acadêmica:</strong> {{ $curriculo->formacao }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                    @if($curriculo->vaga)
                    <strong>Vaga Desejada:</strong> {{ $curriculo->vaga->nome }}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                </p>

                @if($curriculo->salario)
                <p>
                <strong>Pretensão salarial:</strong> R$ {{ $curriculo->salario }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </p>
                @endif
            </td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <table width="100%" cellpadding="0" cellspacing="0" class="">
        <tr>
            <td>
                @if($curriculo->qualificacao)
                <p>
                <strong>Resumo de suas qualificações:</strong> <br />{{ $curriculo->qualificacao }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </p>
                @endif

                @if($curriculo->experiencia)
                <br />
                <p>
                <strong>Experiência profissional:</strong> <br />{{ $curriculo->experiencia }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </p>
                @endif

                @if($curriculo->cursos)
                <br />
                <p>
                <strong>Cursos realizado:</strong> <br />{{ $curriculo->cursos }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </p>
                @endif

                @if($curriculo->idiomas)
                <br />
                <p>
                <strong>Idiomas:</strong> <br />{{ $curriculo->idiomas }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </p>
                @endif

                <br />
                <p>
                <strong>DATA DE ATUALIZAÇÃO:</strong> {{ $curriculo->updated_at->format('d/m/Y H:m') }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <br />
                <strong>DATA DE ENVIO:</strong> {{ $curriculo->created_at->format('d/m/Y H:m') }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </p>
            </td>
        </tr>
    </table>
    <p>&nbsp;</p>
</main>
@endsection
