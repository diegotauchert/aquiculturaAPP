<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

use Illuminate\Support\Facades\Route;

Auth::routes();

// images
Route::get('{path}/{options}/{name}.{extension}', '\Uploadify\Http\Controllers\ImageController@show')
    ->where('path', '[a-z-/]+')
    ->where('options', '[a-z0-9-_,]+')
    ->where('name', '.+?')
    ->where('extension', 'jpe?g|gif|png|JPE?G|GIF|PNG');

// gestor
Route::name('gestor.')->prefix('/gestor')->namespace('Gestor')->middleware(['lang.default', 'cors'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/busca', 'BuscaController@index')->name('busca');

    Route::get('/editar-perfil', 'UsuarioPerfilController@perfil')->name('editar-perfil');
    Route::post('/editar-perfil', 'UsuarioPerfilController@perfilUpdate')->name('editar-perfil-post');

    Route::get('/mudar-senha', 'UsuarioPerfilController@senha')->name('mudar-senha');
    Route::post('/mudar-senha', 'UsuarioPerfilController@senhaUpdate')->name('mudar-senha-post');

    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/login', 'LoginController@login')->name('login');
    Route::get('/password', 'PasswordController@index')->name('password');
    Route::post('/password', 'PasswordController@password')->name('password');

    Route::post('/editar-perfil-upload/{id}', 'UsuarioPerfilController@upload');
    Route::post('/editar-perfil-delete/{id}', 'UsuarioPerfilController@uploadDelete');

    Route::post('/clientes-anexos-upload/{cliente}/{tipo}', 'ClienteAnexoController@upload');
    Route::post('/clientes-anexos-delete/{anexo}', 'ClienteAnexoController@delete');

    Route::post('/mensagens-anexos-upload/{mensagem}', 'MensagemController@upload');

    Route::get('/fazendas/usuario/{id}', 'FazendaController@usuario')->name('fazendas.usuario');
    Route::post('/fazendas/usuario', 'FazendaController@saveUsuario')->name('fazendas.usuario.save');

    Route::get('/mensagens/recebidas', 'MensagemController@recebidas')->name('mensagens.recebida');
    Route::get('/mensagens/{id}/ver', 'MensagemController@edit')->name('mensagens.see');

    Route::resources([
        '/categorias-clientes' => 'CategoriaClienteController',
        '/cidades' => 'CidadeController',
        '/configs' => 'ConfigController',
        '/estados' => 'EstadoController',
        '/menus' => 'MenuController',
        '/modulos' => 'ModuloController',
        '/regioes' => 'RegiaoController',
        '/clientes' => 'ClienteController',
        '/fazendas' => 'FazendaController',
        '/planos' => 'PlanoController',
        '/viveiros' => 'ViveiroController',
        '/produtos' => 'ProdutoController',
        '/lotes' => 'LoteController',
        '/mensagens' => 'MensagemController',
        '/usuarios' => 'UsuarioController',
        '/cultivos' => 'CultivoController',
    ]);
});

// web
Route::name('web.')->prefix('/')->namespace('Web')->group(function () {
    Route::get('/', function () {
        return redirect()->route('gestor.dashboard');
    });
});
