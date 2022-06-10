<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@home')->name('home');

    //TOMAMOS COMO PADRÃO O ->NAME(''); O NOME DO CONTROLADOR/METODO
    Route::get('/categoria', 'CategoriaController@home')->name('categoriahome');
    Route::get('/categoria/nova', 'CategoriaController@adicionar')->name('categoriaadicionar');
    Route::post('/categoria/nova', 'CategoriaController@create')->name('categoriacreate');
    Route::get('/categoria/editar/{id}', 'CategoriaController@editar')->name('categoriaeditar');
    Route::patch('categoria/editar/{id}', 'CategoriaController@update')->name('categoriaupdate');
    Route::delete('/categoria/deletar', 'CategoriaController@delete')->name('categoriadelete');

});
