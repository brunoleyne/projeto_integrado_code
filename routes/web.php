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

Auth::routes();

Route::get('api/fingerprints', 'APIDigitalController@index')->name('api.fingerprints');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'HomeController@logout')->name('logout');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('pacientes', 'PacienteController',
        array('except' => array('destroy', 'show')));
    Route::get('lista/clientes', 'PacienteController@getPacientesList')->name('pacientes.lista');
    Route::get('autocomplete/pacientes', 'PacienteController@getAutoCompletePacientes')->name('autocomplete.pacientes');

    Route::resource('medicos', 'MedicoController',
        array('except' => array('destroy', 'show')));
    Route::get('lista/medicos', 'MedicoController@getMedicosList')->name('medicos.lista');
    Route::get('autocomplete/medicos', 'MedicoController@getAutoCompleteMedicos')->name('autocomplete.medicos');

    Route::resource('fisioterapeutas', 'FisioterapeutaController');
    Route::get('lista/fisioterapeutas', 'FisioterapeutaController@getFisioterapeutaList')->name('fisioterapeutas.lista');
    Route::get('autocomplete/fisioterapeutas', 'FisioterapeutaController@getAutoCompleteFisioterapeutas')->name('autocomplete.fisioterapeutas');

    Route::resource('avaliacoes', 'AvaliacaoController',
        array('except' => array('destroy')));
    Route::get('lista/avaliacoes', 'AvaliacaoController@getAvaliacoesList')->name('avaliacoes.lista');


    Route::resource('fechamento-mensal', 'FechamentoMensalController',
        array('only' => array('index', 'create', 'store', 'edit', 'update')));
    Route::get('lista/fechamento-mensal', 'FechamentoMensalController@getFechamentoMensalList')->name('fechamento-mensal.lista');

    Route::get('entrada/registrar', 'EvolucaoDiariaController@selecionarPacienteEntrada')->name('registrar.entrada');
    Route::post('entrada/registrar', 'EvolucaoDiariaController@registrarEntrada')->name('registrar.entrada.acao');

    Route::resource('evolucoesdiarias', 'EvolucaoDiariaController',
        array('only' => array('edit', 'update', 'destroy')));

    Route::get('lista/evolucoes/{id}', 'AvaliacaoController@getEvolucoesList')->name('avaliacao.evolucoes.lista');

    Route::get('usuario/minha-conta', 'UsuarioController@getProfile')->name('usuario.minha-conta');
    Route::patch('usuario/minha-conta', 'UsuarioController@updateProfile')->name('usuario.minha-conta.update');

    Route::get('carregar-digitais', 'EvolucaoDiariaController@carregarDigitaisPacientes')->name('pacientes.carregar-digitais');

    Route::get('relatorio/pacientes-ausentes', 'RelatorioController@getPacientesAusentes')->name('relatorio.pacientes-ausentes');
    Route::get('lista/pacientes-ausentes', 'RelatorioController@getPacientesAusentesList')->name('pacientes-ausentes.lista');

    Route::get('relatorio/mensal', 'RelatorioController@getRelatorioMensal')->name('relatorio.mensal');
    Route::post('relatorio/mensal', 'RelatorioController@getRelatorioMensal')->name('relatorio.mensal-post');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('avaliacoes/{id}/marcar-infrequente', 'AvaliacaoController@marcarInfrequente')->name('avaliacoes.marcar-infrequente');
        Route::post('avaliacoes/alterar-fisioterapeuta', 'AvaliacaoController@alterarFisioterapeuta')->name('avaliacoes.alterar-fisioterapeuta');
        Route::get('avaliacoes/pausar/tratamento/{id}', 'AvaliacaoController@pausarTratamento')->name('avaliacoes.pausar-tratamento');
        Route::get('avaliacoes/retomar/tratamento/{id}', 'AvaliacaoController@retomarTratamento')->name('avaliacoes.retomar-tratamento');
        Route::post('avaliacoes/adicionar-sessoes', 'EvolucaoDiariaController@adicionarEvolucao')->name('avaliacoes.adicionar-sessoes');
    });
});