<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StandardController;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends StandardController
{
    protected $model;
    protected $name = 'Profile';
    protected $view = 'painel.profiles';
    protected $route = 'perfis';

    public function __construct(Profile $profile)
    {
        $this->model = $profile;

        $this->middleware('can:profiles');

    }

    public function users($id)
    {
        $profile = $this->model->find($id);

        $users = $profile->users()->distinct('user_id')->paginate($this->totalPage);

        $title = "Usuário com o perfil: {$profile->name}";

        return view('painel.profiles.users', compact('profile', 'users', 'title'));
    }

    public function usersAdd($id)
    {
        $profile = $this->model->find($id);
        $users = User::whereNotIn('id', function ($query) use($profile){
            $query->select("profile_user.user_id");
            $query->from("profile_user");
            $query->whereRaw("profile_user.profile_id = {$profile->id}");
    })->get();

        $title = "Vincular usuário ao perfil: {$profile->name}";

        return view('painel.profiles.users-add', compact('users', 'profile', 'title'));
    }

    public function usersAddProfile(Request $request, $id)
    {
        $profile = $this->model->find($id);
        $profile->users()->attach($request->get('users'));

        return redirect()->route('profile.users', $id)->with(['success' => 'Vínculo realizado com sucesso!']);
    }

    public function deleteUser($id, $userId)
    {
        $profile = $this->model->find($id);
        $profile->users()->detach($userId);

        return redirect()->route('profile.users', $id)
            ->with(['success' => 'Removido com sucesso!']);

    }

    public function searchUser($id, Request $request)
    {
        $dataForm = $request->except('_token');

        $profile = $this->model->find($id);

        //Filtrar os dados
        $users = $profile->users()->where('users.name', 'LIKE', "%{$dataForm['key-search']}%")
        ->orWhere('users.email', $dataForm['key-search'])
            ->paginate($this->totalPage);

        return view('painel.profiles.users', compact('users', 'dataForm', 'profile'));
    }

    //permissions
    public function permissions($id)
    {
        $profile = $this->model->find($id);

        $permissions = $profile->permissions()
            ->distinct()
            ->paginate($this->totalPage);

        $title = 'Permissões com o perfil: ' . $profile->name;

        return view('painel.profiles.permissions', compact('profile', 'permissions', 'title'));
    }


    public function listPermissionAdd($id)
    {
        $profile = $this->model->find($id);

        $permissions = Permission::WhereNotIn('id', function ($query) use ($profile) {
            $query->select('permission_profile.permission_id');
            $query->from('permission_profile');
            $query->whereRaw("permission_profile.profile_id = {$profile->id}");
        })->get();

        $title = 'Vincular permissão ao perfil: ' . $profile->name;

        return view('painel.profiles.permissions-add', compact('profile', 'permissions', 'title'));
    }

    public function permissionAddProfile(Request $request, $id)
    {
        $dataForm = $request->get('permissions');

        $profile = $this->model->find($id);

        $profile->permissions()->attach($dataForm);

        return redirect()->route('profiles.permissions', $profile->id)
            ->with('success', 'Permissão adicionada com sucesso!');;
    }

    public function permissionDeleteProfile($id, $permissionId)
    {
        $profile = $this->model->find($id);

        $profile->permissions()->detach($permissionId);

        return redirect()->route('profiles.permissions', $profile->id)
            ->with('success', 'Permissão removida com sucesso!');
    }

    public function searchPermissions(Request $request, $id)
    {
        $dataForm = $request->except('_token');

        $profile = $this->model->find($id);

        $permissions = $profile->permissions()
            ->where(function ($query) use ($dataForm) {
                $query->where('permissions.name', 'LIKE', "%{$dataForm['key-search']}%")
                    ->orWhere('permissions.label', 'LIKE', "%{$dataForm['key-search']}%");
            })->paginate($this->totalPage);

        $title = 'Permissões com o perfil: ' . $profile->name;

        return view('painel.profiles.permissions', compact('profile', 'permissions', 'title', 'dataForm'));
    }


    public function search(Request $request)
    {
        $dataForm = $request->except('_token');

        $data = $this->model->where('name', 'like', "%{$dataForm['key-search']}%")
            ->orWhere('label', 'like', "%{$dataForm['key-search']}%")
            ->paginate($this->totalPage);

        return view("{$this->view}.index", compact('data', 'dataForm'));
    }

}
