# MP AQUICULTURA

## Instalação das dependências

```sh
npm install
composer create-project
```

## Comando do Artisan

Para criar as tabelas no banco de dados

```sh
php artisan migrate
```

Para incluir dados nas tabelas após criadas

```sh
php artisan db:seed
```

Iniciar o servidor

```sh
php artisan serve
```

## Ambiente

Node v12
PHP 7.3

## Links

- Página em breve antes da publicação: http://localhost:8000/
- Link de acesso ao Gestor: http://localhost:8000/gestor

## Pagarme 
 - Basta mudar o API_KEY_PAGARME no env.

 Documentação
 ```sh
https://github.com/pagarme/pagarme-php
```