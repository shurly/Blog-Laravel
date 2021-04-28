<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StandardController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends StandardController
{
    protected $model;
    protected $name = 'Post';
    protected $view = 'painel.posts';
    protected $route = 'posts';
    protected $upload = ['name' => 'image', 'path' => 'posts'];

    public function __construct(Post $post)
    {
        $this->model = $post;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Cadastrar Novo {$this->name}s ";

        $categories = Category::get()->pluck('name', 'id');

        return view("{$this->view}.create-edit", compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Valida os dados
        $this->validate($request, $this->model->rules());

        //Pegar todos os dados e armazenar na variável $dataForm
        $dataForm = $request->all();

        $dataForm['featured'] = isset($dataForm['featured']) ? true : false;
        $dataForm['user_id'] = auth()->user()->id;

        //Verifica se existe arquivo
        if ($this->upload && $request->hasFile($this->upload['name'])) {
            //Pega a imagem
            $image = $request->file($this->upload['name']);

            //define o nome do arquivo
            $nameFile = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
            $upload = $image->storeAs($this->upload['path'], $nameFile);

            if ($upload) {
                $dataForm[$this->upload['name']] = $nameFile;
            } else {
                return redirect()->route("{$this->route}.create")
                    ->withErrors(['errors' => 'Erro no upload'])
                    ->withInput();
            }
        }

        //Insere os dados
        $insert = $this->model->create($dataForm);

        if ($insert) {

            return redirect()->route("{$this->route}.index")->with(['success' => 'Cadastro realizado com sucesso']);
        } else {

            return redirect()->route("{$this->route}.create")
                ->withErrors(['errors' => 'Falha ao cadastrar'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->model->find($id);
        $title = "Alterar {$this->name}:  $data->title";

        $categories = Category::get()->pluck('name', 'id');

        return view("{$this->view}.create-edit", compact('title', 'data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validar dados
        $this->validate($request, $this->model->rules($id));

        //Pegar todos os dados e armazenar na variavel $dataForm
        $dataForm = $request->all();

        //Pegar objeto de model
        $data = $this->model->find($id);

        $dataForm['featured'] = isset($dataForm['featured']) ? true : false;

        //Verifica se existe arquivo
        if ($this->upload && $request->hasFile($this->upload['name'])) {
            //Pega a imagem
            $image = $request->file($this->upload['name']);

            //Verifica se arquivo existe
            if( $data->image == ''  ){
                $nameFile = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
                $dataForm[$this->upload['name']] = $nameFile;
            }else{
                $nameFile = $data->image;
                $dataForm[$this->upload['name']] = $data->image;
            }

            //define o nome do arquivo
            $upload = $image->storeAs($this->upload['path'], $nameFile);

            if ($upload) {
                $dataForm[$this->upload['name']] = $nameFile;
            }else{
                return redirect()->route("{$this->route}.edit", ['id' => $id])
                    ->withErrors(['errors' => 'Erro no upload'])
                    ->withInput();
            }
        }


        //Atualizar os dados do model
        $update = $data->update($dataForm);

        if ($update) {

            return redirect()->route("{$this->route}.index")->with(['success' => 'Alteração realizada com sucesso']);

        } else {

            return redirect()->route("{$this->route}.edit", ['id' => $id])
                ->withErrors(['errors' => 'Falha ao editar'])
                ->withInput();
        }
    }

    public function search(Request $request)
    {
        //Recuperar os dados do formulário
        $dataForm = $request->except('_token');

        //Filtrar as categorias
        $data = $this->model
            ->where('title', 'LIKE', "%{$dataForm['key-search']}%")
            ->orwhere('description', 'LIKE', "%{$dataForm['key-search']}%")
            ->paginate($this->totalPage);

        return view("{$this->view}.index", compact('data', 'dataForm'));

    }

}
