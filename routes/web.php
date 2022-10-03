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
    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

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

    Route::post('/banners-upload/{banner}', 'BannerController@upload');
    Route::post('/banners-delete/{banner}', 'BannerController@uploadDelete');

    Route::post('/downloads-upload/{download}', 'DownloadController@upload');
    Route::post('/downloads-delete/{download}', 'DownloadController@uploadDelete');
    Route::post('/editar-perfil-upload/{id}', 'UsuarioPerfilController@upload');
    Route::post('/editar-perfil-delete/{id}', 'UsuarioPerfilController@uploadDelete');

    Route::post('/paginas-anexos-upload/{pagina}/{tipo}', 'PaginaAnexoController@upload');
    Route::post('/paginas-anexos-delete/{anexo}', 'PaginaAnexoController@delete');
    Route::post('/posts-anexos-upload/{post}/{tipo}', 'PostAnexoController@upload');
    Route::post('/posts-anexos-delete/{anexo}', 'PostAnexoController@delete');

    Route::get('/lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

    Route::post('/agendas-anexos-upload/{post}/{tipo}', 'AgendaAnexoController@upload');
    Route::post('/agendas-anexos-delete/{anexo}', 'AgendaAnexoController@delete');

    Route::post('/coberturas-anexos-upload/{post}/{tipo}', 'CoberturaAnexoController@upload');
    Route::post('/coberturas-anexos-delete/{anexo}', 'CoberturaAnexoController@delete');

    Route::post('/colunistas-anexos-upload/{post}/{tipo}', 'ColunistaAnexoController@upload');
    Route::post('/colunistas-anexos-delete/{anexo}', 'ColunistaAnexoController@delete');

    Route::post('/ensaios-anexos-upload/{post}/{tipo}', 'EnsaioAnexoController@upload');
    Route::post('/ensaios-anexos-delete/{anexo}', 'EnsaioAnexoController@delete');

    Route::post('/vaipraonde-anexos-upload/{post}/{tipo}', 'VaiPraOndeAnexoController@upload');
    Route::post('/vaipraonde-anexos-delete/{anexo}', 'VaiPraOndeAnexoController@delete');

    Route::post('/videos-anexos-upload/{post}/{tipo}', 'VideoAnexoController@upload');
    Route::post('/videos-anexos-delete/{anexo}', 'VideoAnexoController@delete');

    Route::post('/depoimentos-upload/{depoimento}', 'DepoimentoController@upload');
    Route::post('/depoimentos-delete/{depoimento}', 'DepoimentoController@uploadDelete');

    Route::resources([
        '/banners' => 'BannerController',
        '/banners-categorias' => 'BannerCategoriaController',
        '/origem' => 'OrigemController',
        '/categorias-posts' => 'CategoriaPostController',
        '/cidades' => 'CidadeController',
        '/configs' => 'ConfigController',
        '/downloads' => 'DownloadController',
        '/depoimentos' => 'DepoimentoController',
        '/estados' => 'EstadoController',
        '/interessados' => 'InteressadoController',
        '/menus' => 'MenuController',
        '/langs' => 'LangController',
        '/modulos' => 'ModuloController',
        '/regioes' => 'RegiaoController',
        '/paginas' => 'PaginaController',
        '/posts' => 'PostController',
        '/usuarios' => 'UsuarioController',
        '/vagas' => 'VagaController',
        '/curriculos' => 'CurriculoController',
        '/servicos' => 'ServicoController',
        '/agendas' => 'AgendaController',
        '/agendas-categorias' => 'AgendaCategoriaController',
        '/coberturas' => 'CoberturaController',
        '/coberturas-categorias' => 'CoberturaCategoriaController',
        '/colunistas' => 'ColunistaController',
        '/colunistas-categorias' => 'ColunistaCategoriaController',
        '/ensaios' => 'EnsaioController',
        '/ensaios-categorias' => 'EnsaioCategoriaController',
        '/vaipraonde' => 'VaiPraOndeController',
        '/vaipraonde-categorias' => 'VaiPraOndeCategoriaController',
        '/videos' => 'VideoController',
        '/videos-categorias' => 'VideoCategoriaController',
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
