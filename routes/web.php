<?php

use App\Evento;

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

Route::get('/', function () {

    $evento = Evento::orderBy('data_realizacao', 'DESC')->first();
    return view('welcome', compact('evento'));
});


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('eventos', 'EventoController');
    Route::get('eventos/{evento}/subscribe', 'EventoController@subscribe')->name('eventos.subscribe');
    Route::get('eventos/{evento}/unsubscribe', 'EventoController@unsubscribe')->name('eventos.unsubscribe');
    Route::get('eventos/{evento}/draw', 'EventoController@draw')->name('evento.draw');

    Route::resource('eventos/{evento}/presentes', 'PresenteController');
    Route::resource('presentes/{presente}/fotos', 'FotoController');
});

Route::get('/run-install',  'UpdateController@install');
Route::get('/run-artisan',  'UpdateController@artisan');
