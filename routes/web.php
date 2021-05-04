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
    return view('painel/home/index');
})->middleware(['auth'])->name('painel');


Route::get('/', function () {
    return view('site/home/index');
});

require __DIR__.'/auth.php';



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

    //Routes Comments
    Route::any('comentarios/pesquisar', [App\Http\Controllers\Painel\CommentController::class, 'search'])->name('comments.search');
    Route::get('comentarios', [App\Http\Controllers\Painel\CommentController::class, 'index'])->name('comments');
    Route::get('comentarios/{id}/respostas', [App\Http\Controllers\Painel\CommentController::class, 'answers']);
    Route::post('comentarios/{id}/answer', [App\Http\Controllers\Painel\CommentController::class, 'answerComment'])->name('answer-comment');
    Route::post('comentarios/{id}/destroy', [App\Http\Controllers\Painel\CommentController::class, 'destroy'])->name('destroy-comment');
    Route::get('comentarios/{id}/respostas/{idAnswer}/delete', [App\Http\Controllers\Painel\CommentController::class, 'destroyAnswer'])->name('destroy-answer');


    Route::get('/', [App\Http\Controllers\Painel\PainelController::class, 'index']);

});

/*********************************** Rotas Site *****************************************
 * ****************************************************************************************
 * ***************************************************************************************/

Route::any('/buscar', [App\Http\Controllers\Site\SiteController::class, 'search'])->name('search.blog');
Route::post('/comment-post', [App\Http\Controllers\Site\SiteController::class, 'commentPost'])->name('comment');
Route::get('/tutorial/{url}', [App\Http\Controllers\Site\SiteController::class, 'post'])->name('post');
Route::get('/categoria/{url}', [App\Http\Controllers\Site\SiteController::class, 'category']);
Route::get('/', [App\Http\Controllers\Site\SiteController::class, 'index']);
Route::get('empresa', [App\Http\Controllers\Site\SiteController::class, 'company']);
Route::get('contato', [App\Http\Controllers\Site\SiteController::class, 'contact']);








