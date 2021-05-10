<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Painel\UserFormRequest;
use App\Http\Requests\Painel\UserFormEditRequest;

class UserController extends Controller
{
    private $user;
    protected $totalPage = 2;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->middleware('can:users');


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'LIstagem de Usuários';

        $users = $this->user->paginate($this->totalPage);

        return view('painel.users.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar Novo Usuários';

        return view('painel.users.create-edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        //Pegar todos os dados de usuários e armazenar na variavel $dataform
        $dataUser = $request->all();

        //Criptografa a senha
        $dataUser['password'] = bcrypt($dataUser['password']);


        //Verifica se existe imagem
        if ($request->hasFile('image')) {
            //Pega a imagem
            $image = $request->file('image');

            //define o nome da imagem
            $nameImage = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
            $upload = $image->storeAs('users', $nameImage);

            if ($upload) {
                $dataUser['image'] = $nameImage;
            } else {
                return redirect('/painel/usuarios/create-edit')->withErrors(['errors' => 'Erro no upload'])
                    ->withInput();
            }
        }

        //Insere os dados do usuário
        $insert = $this->user->create($dataUser);

        if ($insert) {

            return redirect()->route('usuarios.index')->with(['success' => 'Cadastro realizado com sucesso']);
        } else {

            return redirect()->route('usuarios.create')
                ->withErrors(['errors' => 'Falha ao cadastrar'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Visualizar Usuários';

        $user = $this->user->find($id);

        return view('painel.users.show', compact('user', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Editar Usuários';

        //Recuperar o usuário pelo id
        $user = $this->user->find($id);

        return view('painel.users.create-edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {

        //Pegar todos os dados de usuários e armazenar na variavel $dataform
        $dataUser = $request->all();

        //Pegar objeto de usuário
        $user = $this->user->find($id);


        //Criptografa a senha
        $dataUser['password'] = bcrypt($dataUser['password']);


        //Verifica se existe imagem
        if ($request->hasFile('image')) {
            //Pega a imagem
            $image = $request->file('image');

            if($user->image == ''){
                $nameImage = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
                $dataUser['image'] = $nameImage;
            }else{
                $nameImage = $user->image;
                $dataUser['image'] = $user->image;
            }

            //define o nome da imagem
            $upload = $image->storeAs('users', $nameImage);

            if (!$upload) {
                return redirect()->route('usuarios.edit', ['id' => $id])
                    ->withErrors(['errors' => 'Erro no upload'])
                    ->withInput();
            }
        }

        //Atualizar os dados do usuário
        $update = $user->update($dataUser);

        if ($update) {

            return redirect()->route('usuarios.index')->with(['success' => 'Alteração realizada com sucesso']);

        } else {

            return redirect()->route('usuarios.edit', ['id' => $id])
                ->withErrors(['errors' => 'Falha ao editar'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Recuperar usuário
        $user = $this->user->find($id);

        // Deletar
        $delete = $user->delete();
        if ($delete) {
            return redirect()->route('usuarios.index');
        } else {
            return redirect()->route('usuarios.show', ['id' => $id])
                ->withErrors(['errors' => 'Falha ao deletar']);
        }
    }

    public function search(Request $request){
        //Recuperar os dados do formulário
        $dataForm = $request->except('_token');

        //Filtrar os usuários
       $users = $this->user->where('name', 'LIKE', "%{$dataForm['key-search']}%")
            ->orWhere('email', $dataForm['key-search'])->paginate($this->totalPage);

       return view('painel.users.index', compact('users', 'dataForm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile()
    {
        $title = 'Meu Perfil';

        //Recuperar o usuário
        $user = auth()->user();

        return view('painel.users.profile', compact('user', 'title'));
    }

    public function updateProfile(UserFormRequest $request, $id)
    {

        $this->authorize('update_profile', $id);

        //Pegar todos os dados de usuários e armazenar na variavel $dataform
        $dataUser = $request->all();

        //Pegar objeto de usuário
        $user = $this->user->find($id);


        //Criptografa a senha
        $dataUser['password'] = bcrypt($dataUser['password']);

        //Não permitir que usuário altere e-mail
        unset($dataUser['email']);


        //Verifica se existe imagem
        if ($request->hasFile('image')) {
            //Pega a imagem
            $image = $request->file('image');

            if($user->image == ''){
                $nameImage = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
                $dataUser['image'] = $nameImage;
            }else{
                $nameImage = $user->image;
                $dataUser['image'] = $nameImage;
            }

            //define o nome da imagem
            $upload = $image->storeAs('users', $nameImage);

            if (!$upload) {
                return redirect()->route('profile')
                    ->withErrors(['errors' => 'Erro no upload'])
                    ->withInput();
            }
        }

        //Atualizar os dados do usuário
        $update = $user->update($dataUser);

        if ($update) {

            return redirect()->route('profile')->with(['success' => 'Alteração realizada com sucesso']);

        } else {

            return redirect()->route('usuarios.edit', ['id' => $id])
                ->withErrors(['errors' => 'Falha ao editar'])
                ->withInput();
        }
    }

}
