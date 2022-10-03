<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\UsuarioLog;
use Faker\Generator as Faker;

/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | This directory should contain each of the model factory definitions for
  | your application. Factories provide a convenient way to generate new
  | model instances for testing / seeding your application's database.
  |
 */

$factory->define(UsuarioLog::class, function(Faker $faker) {
    $tipo = random_int(1, 3);

    if ($tipo != 1) {
        $situacao = 1;
    } else {
        $situacao = random_int(1, 2);
    }

    return [
        'usuario_id' => 1,
        'data' => $faker->dateTime,
        'session' => $faker->sha1,
        'ip' => $faker->ipv4,
        'mensagem' => $faker->text,
        'info' => $faker->userAgent,
        'tipo' => $tipo,
        'situacao' => $situacao,
    ];
});
