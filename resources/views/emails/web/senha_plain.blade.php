
Olá {{ $usuario->present()->makeApelido ?? $usuario->present()->apelido }},

Você solicitou uma nova senha no {{ config('app.name') }} ({{ url('/') }}).
Para te ajudar no acesso, geramos esta senha provisória.

E-mail: {{ $usuario->email }}
Senha: {{ $senha }}

Lembre-se letras maiusculas e minusculas são diferentes!
Para continuar seguro, peço que altere ela assim que acessar.

Até mais.
