<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentAnswer;


class CommentController extends Controller
{
    private $comment;
    private $totalPage = 5;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {
        $data = $this->comment
            ->where('status', 'R')
            ->paginate($this->totalPage);
        $title = 'Listagem de Comentários';

        return view('painel.comments.index', compact('data', 'title'));
    }

    public function search(Request $request)
    {
        //Recuperar os dados do formulário
        $dataForm = $request->except('_token');

        //Filtrar as dados
        if ($dataForm['key-search']) {
            $data = $this->comment
                ->where('name', 'LIKE', "%{$dataForm['key-search']}%")
                ->where('status', $dataForm['status'])
                ->orWhere('description', 'LIKE', "%{$dataForm['key-search']}%")
                ->paginate($this->totalPage);
        } else {
            $data = $this->comment
                ->where('status', $dataForm['status'])
                ->paginate($this->totalPage);
        }


        return view('painel.comments.index', compact('data', 'dataForm'));
    }

    public function answers($id)
    {
        $comment = $this->comment->find($id);
        $answers = $comment->answers()->get();
        $title = "Respostas comentário feito por: {$comment->name}";

        return view('painel.comments.answers', compact('comment', 'answers', 'title'));
    }

    public function answerComment(Request $request, $id)
    {
        $this->validate($request, $this->comment->rulesAnswerComment());

        $comment = $this->comment->find($id);

        $dataForm = $request->all();
        $dataForm['user_id'] = auth()->user()->id;
        $dataForm['date'] = date('Y-m-d');
        $dataForm['hour'] = date('H:i:s');

        $reply = $comment->answers()->create($dataForm);

        if($reply){
            //event(new \App\Events\CommentAnswered($comment, $reply));

            return redirect()->back()->with(['seccess' => 'Comentário enviado com sucesso']);
        }
        else{
            return redirect()->back()->withErrors(['errors' => 'Falha ao responder'])->withInput();
        }

    }

    public function destroy($id)
    {
        //Recuperar dados
        $data = $this->comment->find($id);

        // Deletar
        $delete = $data->delete();
        if ($delete) {
            return redirect()->route("comments")
                ->with(['success' => "Comentário foi deletado com sucesso"]);
        } else {
            return redirect()->back()
                ->withErrors(['errors' => 'Falha ao deletar']);
        }
    }

    public function destroyAnswer($id, $idAnswer)
    {
        $answerComment = CommentAnswer::find($idAnswer);

        // Deletar
        $delete = $answerComment->delete();

        if ($delete) {
            return redirect()->back()
                ->with(['success' => "Resposta foi deletada com sucesso"]);
        } else {
            return redirect()->back()
                ->withErrors(['errors' => 'Falha ao deletar']);
        }
    }

}
