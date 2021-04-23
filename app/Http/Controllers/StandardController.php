<?php

namespace App\Http\Controllers;

use App\Http\Models;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class StandardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $totalPage = 10;
    protected $upload = false;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Listagem {$this->name}s";
        $data = $this->model->paginate($this->totalPage);

        return view("{$this->view}.index", compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Cadastrar Nova {$this->name}s ";

        return view("{$this->view}.create-edit", compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Valida os dados
        $this->validate($request, $this->model->rules());

        //Pegar todos os dados e armazenar na variável $dataForm
        $dataForm = $request->all();

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->model->find($id);

        $title = "{$this->name}: $data->name";

        return view("{$this->view}.show", compact('title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data= $this->model->find($id);
        $title = "Alterar {$this->name}:  $data->name";

        return view("{$this->view}.create-edit", compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Recuperar categoria
        $data = $this->model->find($id);

        // Deletar
        $delete = $data->delete();
        if ($delete) {
            return redirect()->route("{$this->route}.index")
                ->with(['success' => "<b>$data->name</b> foi deletado com sucesso"]);
        } else {
            return redirect()->route("{$this->route}.show", ['id' => $id])
                ->withErrors(['errors' => 'Falha ao deletar']);
        }
    }

    public function search(Request $request)
    {
        //Recuperar os dados do formulário
        $dataForm = $request->except('_token');

        //Filtrar as categorias
        $data = $this->model->where('name', 'LIKE', "%{$dataForm['key-search']}%");

        return view("{$this->view}.index", compact('data', 'dataForm'));

    }

}
