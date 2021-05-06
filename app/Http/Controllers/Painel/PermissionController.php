<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StandardController;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Permission;

class PermissionController extends StandardController
{
    protected $model;
    protected $name = 'Permissão';
    protected $view = 'painel.permissions';
    protected $route = 'permissoes';

    public function __construct(Permission $permission)
    {
        $this->model = $permission;

    }

    public function profiles($id)
    {
        $permission = $this->model->find($id);

        $profiles = $permission->profiles()
            ->paginate($this->totalPage);

        $title = 'Perfis com a permissão: ' . $permission->name;

        return view('painel.permissions.permissions', compact('permission', 'profiles', 'title'));
    }

    public function searchProfiles(Request $request, $id)
    {
        $dataForm = $request->except('_token');

        $permission = $this->model->find($id);

        $profiles = $permission->profiles()
            ->where('profiles.name', 'LIKE', "%{$dataForm['key-search']}%")
            ->orWhere('profiles.label', 'LIKE', "%{$dataForm['key-search']}%")
            ->paginate($this->totalPage);

        $title = 'Perfis com a permissão: ' . $permission->name;

        return view('painel.permissions.permissions', compact('permission', 'profiles', 'dataForm', 'title'));
    }

    public function permissionAdd($id)
    {
        $permission = $this->model->find($id);


        $profiles = Profile::WhereNotIn('id', function ($query) use ($permission) {
            $query->select('permission_profile.profile_id');
            $query->from('permission_profile');
            $query->whereRaw("permission_profile.permission_id = {$permission->id}");
        })->get();

        $title = "Vincular perfil a permissão: {$permission->name}" ;


        return view('painel.permissions.permission-add', compact('permission', 'profiles', 'title'));


    }

    public function deletePermission($id, $profileId)
    {
        $permission = $this->model->find($id);

        $permission->profiles()->detach($profileId);

        return redirect()->route('permissoes.perfis', $permission->id)
            ->with('success', 'Perfil removido com sucesso!');
    }

    public function permissionAddProfile(Request $request, $id)
    {
        $dataForm = $request->get('profiles');

        $permission = $this->model->find($id);

        $permission->profiles()->attach($dataForm);

        return redirect()->route('permissoes.perfis', $permission->id)
            ->with('success', 'Perfil adicionado com sucesso!');
    }


    public function search(Request $request)
    {
        $dataForm = $request->except('_token');

        $data = $this->model->where('name', 'like', "%{$dataForm['pesquisa']}%")
            ->orWhere('label', 'like', "%{$dataForm['pesquisa']}%")
            ->paginate($this->totalPage);

        return view("{$this->view}.index", compact('data', 'dataForm'));
    }
}
