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

    Route::post('/clientes-anexos-upload/{post}/{tipo}', 'PostAnexoController@upload');
    Route::post('/clientes-anexos-delete/{anexo}', 'PostAnexoController@delete');

    Route::resources([
        '/categorias-posts' => 'CategoriaPostController',
        '/cidades' => 'CidadeController',
        '/configs' => 'ConfigController',
        '/estados' => 'EstadoController',
        '/menus' => 'MenuController',
        '/modulos' => 'ModuloController',
        '/regioes' => 'RegiaoController',
        '/clientes' => 'PostController',
        '/usuarios' => 'UsuarioController',
    ]);
});

// embreve
Route::get('/', function () {
    $emails = [env("CLIENTE_EMAIL")];

    $telefones = [env("CLIENTE_TELEFONE")];

    $endereco = [
        'rua' => "",
        'numero' => "",
        'complemento' => null,
        'bairro' => "",
        'cep' => "",
        'cidade' => "",
        'estado' => ""
    ];

    return view('layouts.embreve.app', compact('emails', 'telefones', 'endereco'));
});


// web
Route::name('web.')->prefix('/')->namespace('Web')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/home', function () {
        return redirect()->route('web.home');
    });


    Route::get('/busca', 'BuscaController@index')->name('busca');

    // ENVIAR EMAIL CONTATO
    Route::post('/contato', 'ContatoController@send')->name('contato.send');
    Route::get('/contato', 'ContatoController@index')->name('contato');
    
    Route::post('/trabalhe-conosco', 'TrabalheController@send')->name('trabalhe.send');
    Route::get('/trabalhe-conosco', 'TrabalheController@index')->name('trabalhe');

    Route::post('/divulgue-seu-evento', 'DivulgueController@send')->name('divulgue.send');
    Route::get('/divulgue-seu-evento', 'DivulgueController@index')->name('divulgue');

    Route::get('/downloads', 'DownloadController@index')->name('downloads');
    Route::get('/instrucoes', 'InstrucaoController@index')->name('instrucoes');
    Route::post('/newsletter', 'InteressadoController@create')->name('interessado.create');

    Route::get('/depoimentos', 'DepoimentoController@index')->name('depoimentos');
    Route::get('/depoimentos/{depoimento}/{nome}', 'DepoimentoController@depoimento')->name('depoimento.id');

    Route::get('/noticias', 'BlogController@index')->name('blog');
    Route::get('/noticias/{categoria?}', 'BlogController@index')->name('blog.categoria');
    Route::get('/noticias/{post}/{nome?}', 'BlogController@post')->name('blog.id');
    Route::get('/promocoes', 'BlogController@promocao')->name('blog.promocao');
    Route::get('/promocoes/{post}/{nome?}', 'BlogController@post')->name('blog.promocao.id');

    Route::get('/agenda', 'AgendaController@index')->name('agenda');
    Route::get('/agenda/{categoria?}', 'AgendaController@index')->name('agenda.categoria');
    Route::get('/agenda/{post}/{nome?}', 'AgendaController@post')->name('agenda.id');

    Route::get('/coberturas', 'CoberturaController@index')->name('cobertura');
    Route::get('/coberturas/{categoria?}', 'CoberturaController@index')->name('cobertura.categoria');
    Route::get('/coberturas/{post}/{nome?}', 'CoberturaController@post')->name('cobertura.id');

    Route::get('/colunistas', 'ColunistaController@index')->name('colunista');
    Route::get('/colunistas/{categoria?}', 'ColunistaController@index')->name('colunista.categoria');
    Route::get('/colunistas/{post}/{nome?}', 'ColunistaController@post')->name('colunista.id');

    Route::get('/ensaios', 'EnsaioController@index')->name('ensaio');
    Route::get('/ensaios/{categoria?}', 'EnsaioController@index')->name('ensaio.categoria');
    Route::get('/ensaios/{post}/{nome?}', 'EnsaioController@post')->name('ensaio.id');

    Route::get('/tv-ajufest', 'VideoController@index')->name('tv-ajufest');
    Route::get('/tv-ajufest/{categoria?}', 'VideoController@index')->name('tv-ajufest.categoria');
    Route::get('/tv-ajufest/{post}/{nome?}', 'VideoController@post')->name('tv-ajufest.id');

    Route::get('/vai-pra-onde', 'VaiPraOndeController@index')->name('vaipraonde');
    Route::get('/vai-pra-onde/{categoria?}', 'VaiPraOndeController@index')->name('vaipraonde.categoria');
    Route::get('/vai-pra-onde/{post}/{nome?}', 'VaiPraOndeController@post')->name('vaipraonde.id');

    Route::get('/{pagina}', 'HomeController@page')->name('pagina');
});
