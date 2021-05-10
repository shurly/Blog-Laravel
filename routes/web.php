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


    //Routes Profiles
    Route::any('perfis/{id}/usuarios/search', [App\Http\Controllers\Painel\ProfileController::class, 'searchUser'])->name('profile.users.search');
    Route::any('perfis/pesquisar', [App\Http\Controllers\Painel\ProfileController::class, 'search'])->name('perfis.search');
    Route::get('perfis/{id}/usuarios', [App\Http\Controllers\Painel\ProfileController::class, 'users'])->name('profile.users');
    Route::resource('perfis', App\Http\Controllers\Painel\ProfileController::class);
    Route::get('perfis/{id}/usuarios/cadastrar', [App\Http\Controllers\Painel\ProfileController::class, 'usersAdd'])->name('profile.users.add');
    Route::post('perfis/{id}/usuarios/cadastrar', [App\Http\Controllers\Painel\ProfileController::class, 'usersAddProfile'])->name('profile.users.add');
    Route::get('perfis/{id}/usuarios/{userId}/delete', [App\Http\Controllers\Painel\ProfileController::class, 'deleteUser'])->name('profile.user.delete');


    Route::get('profiles/{id}/permissao' , [App\Http\Controllers\Painel\ProfileController::class, 'permissions'])->name('profiles.permissions');
    Route::get('profiles/{id}/permissao/cadastrar', [App\Http\Controllers\Painel\ProfileController::class, 'listPermissionAdd'])->name('profiles.permissions.list');
    Route::post('profiles/{id}/permissao/cadastrar', [App\Http\Controllers\Painel\ProfileController::class, 'permissionAddProfile'])->name('profiles.permissions.add');
    Route::get('profiles/{id}/permissao/{permissionId}/delete', [App\Http\Controllers\Painel\ProfileController::class, 'permissionDeleteProfile'])->name('profiles.permissions.delete');


    //Routes Permissions
    Route::any('permissoes/{id}/perfis/search', [App\Http\Controllers\Painel\PermissionController::class, 'searchProfiles'])->name('profile.permissions.search');
    Route::any('permissoes/pesquisar', [App\Http\Controllers\Painel\PermissionController::class, 'search'])->name('permissions.search');
    Route::resource('permissoes', App\Http\Controllers\Painel\PermissionController::class);
    Route::get('permissoes/{id}/perfis', [App\Http\Controllers\Painel\PermissionController::class, 'profiles'])->name('permissoes.perfis');
    Route::get('permissoes/{id}/perfis/cadastrar', [App\Http\Controllers\Painel\PermissionController::class, 'permissionAdd'])->name('permissions.profile.add');
    Route::post('permissoes/{id}/perfis/cadastrar', [App\Http\Controllers\Painel\PermissionController::class, 'permissionAddProfile'])->name('permissions.profile.add');
    Route::get('permissoes/{id}/perfis/{profileId}/delete', [App\Http\Controllers\Painel\PermissionController::class, 'deletePermission'])->name('permissions.profile.delete');


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








