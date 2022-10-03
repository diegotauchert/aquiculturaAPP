@extends('layouts.web.email')

@section('content')
<a href="{{ url('/') }}" style="float:right;"><img height="80" src="https://rifaclass.com.br/images/logo.png" /></a><br />
<p>Parabéns <strong style="font-size:20px;">{{ $field['nome'] }},</strong> seu pagamento foi confimado com sucesso.</p>
<p>Agora você está concorrendo a nossa rifa <strong style="font-size:20px;">{{ $field['veiculo'] }}</strong></p>
<hr />
<p>
Acesse nosso sistema pelo link <br />
<a href="https://rifaclass.com.br/" target="_blank">
    https://rifaclass.com.br/
</a>
</p>
@endsection
