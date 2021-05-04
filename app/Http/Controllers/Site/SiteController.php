<?php

namespace App\Http\Controllers\Site;

use App\Events\PostViewed;
use App\Http\Controllers\Controller;
use App\Mail\SendContact;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class SiteController extends Controller
{
    private $post;
    private $totalPage = 1;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index()
    {
        $title = 'Blog Shirlei';
        $postsFeatured = $this->post->where('featured', true)->limit(3)->get();
        $posts = $this->post->orderBy('date', 'DESC')->paginate($this->totalPage);

        return view('site.home.index', compact('title', 'postsFeatured', 'posts'));
    }

    public function company()
    {

        $title = 'Empresa Shirlei';
        return view('site.company.company', compact('title'));
    }

    public function contact()
    {

        $title = 'Contato Shirlei';
        return view('site.contact.contact', compact('title'));
    }

    public function category(Category $category, $url)
    {
        $category = $category->where('url', $url)->get()->first();
        $title = "{$category->name}";
        $posts = $category->posts()->paginate($this->totalPage);

        return view('site.category.category', compact('category', 'posts', 'title'));
    }

    public function post($url)
    {
        $post = $this->post->where('url', $url)->get()->first();
        $title = "{$post->title}";
        $postsRel = $this->post->where('id', '>', $post->id)->limit(4)->get();

        event(new \App\Events\PostViewed($post));

        return view('site.post.post', compact('post', 'title', 'postsRel'));
    }

    public function commentPost(Request $request)
    {
        $comment = new Comment;
        $dataForm = $request->all();

        $validate = validator($dataForm,$comment->rules());
        if( $validate->fails() ){
            $msgErrors = '';

            foreach ($validate->messages()->all("<p>:message</p>") as $message){
                $msgErrors .= $message;
            }

            return $msgErrors;
        }

        if($comment->newComment($dataForm))
            return '1';
        else
            return 'Falha ao cadastrar comentário';

    }

    public function search(Request $request)
    {
        $dataForm = $request->except('_token');
        $posts = $this->post
            ->where('title', 'LIKE', "%{$dataForm['key-search']}%")
            ->orWhere('description', 'LIKE', "%{$dataForm['key-search']}%")
            ->orderBy('date', 'DESC')->paginate($this->totalPage);

        return view('site.search.search', compact('dataForm', 'posts'));
    }
}
