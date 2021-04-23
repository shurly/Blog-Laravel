<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

/*********************************** Rotas Painel *****************************************
 * ****************************************************************************************
 * ***************************************************************************************/

Route::group(['prefix' => 'painel', 'middleware' => 'auth'], function (){
    //Routes de Users
    Route::any('usuarios/pesquisar', [App\Http\Controllers\Painel\UserController::class, 'search'])->name('usuarios.search');
    Route::resource('usuarios', App\Http\Controllers\Painel\UserController::class);

    //Routes de Categories
    Route::any('categorias/pesquisar', [App\Http\Controllers\Painel\CategoryController::class, 'search'])->name('categorias.search');
    Route::resource('categorias', App\Http\Controllers\Painel\CategoryController::class);


    Route::get('/', [App\Http\Controllers\Painel\PainelController::class, 'index']);

});

/*********************************** Rotas Site *****************************************
 * ****************************************************************************************
 * ***************************************************************************************/

Route::get('/', [App\Http\Controllers\Site\SiteController::class, 'index']);





