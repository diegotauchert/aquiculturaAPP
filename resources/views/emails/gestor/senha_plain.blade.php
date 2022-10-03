
Olá {{ $usuario->present()->apelido }},

Você solicitou uma nova senha no Gestor ({{ url('/gestor') }}).
Para te ajudar no acesso, geramos esta senha provisória.

Usuário: {{ $usuario->login }}
Senha: {{ $senha }}

Lembre-se letras maiusculas e minusculas são diferentes!
Para continuar seguro, peço que altere ela assim que acessar o Gestor.

Até mais.
