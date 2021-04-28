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

/*********************************** Rotas Painel *****************************************
 * ****************************************************************************************
 * ***************************************************************************************/

Route::group(['prefix' => 'painel', 'middleware' => 'auth'], function (){
    //Routes Users
    Route::any('usuarios/pesquisar', [App\Http\Controllers\Painel\UserController::class, 'search'])->name('usuarios.search');
    Route::resource('usuarios', App\Http\Controllers\Painel\UserController::class);

    //Routes Categories
    Route::any('categorias/pesquisar', [App\Http\Controllers\Painel\CategoryController::class, 'search'])->name('categorias.search');
    Route::resource('categorias', App\Http\Controllers\Painel\CategoryController::class);

    //Routes Posts
    Route::any('posts/pesquisar', [App\Http\Controllers\Painel\PostController::class, 'search'])->name('posts.search');
    Route::resource('posts', App\Http\Controllers\Painel\PostController::class);

    //Routes Profile
    Route::get('perfil', [App\Http\Controllers\Painel\UserController::class, 'showProfile'])->name('profile');
    Route::post('perfil/{id}', [App\Http\Controllers\Painel\UserController::class, 'updateProfile'])->name('profile.update');


    Route::get('/', [App\Http\Controllers\Painel\PainelController::class, 'index']);

});

/*********************************** Rotas Site *****************************************
 * ****************************************************************************************
 * ***************************************************************************************/

Route::get('/', [App\Http\Controllers\Site\SiteController::class, 'index']);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/', function () {
    return view('site/home/index');
});

require __DIR__.'/auth.php';

