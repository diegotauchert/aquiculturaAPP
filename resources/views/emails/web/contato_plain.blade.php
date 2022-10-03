Você recebeu um novo contato através do site {{ config('app.name') }} ({{ url('/') }}).

Informações do contato

Nome: {{ $field['nome'] }}
Telefone: {{ $field['telefone'] }}
E-mail: {{ $field['email'] }}
@if($field['cidade'])
Cidade: {{ $field['cidade'] }}
@endif
@if($field['estado'])
Estado: {{ $field['estado'] }}
@endif
@if($field['evento'])
Evento: {{ $field['evento'] }}
@endif
@if($field['data'])
Data Aproximada: {{ $field['data'] }}
@endif

Mensagem enviada

{{ $field['mensagem'] }}
