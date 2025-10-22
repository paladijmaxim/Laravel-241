<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Events\NewArticleEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $articles = Cache::remember('articles_'.$page, 300, function(){
            return Article::latest()->paginate(5); 
        });
        return view('/article/article', ['articles'=> $articles]);
    }

    public function create()
    {
        Gate::authorize('create', Article::class);
        return view('article.create');
    }

    public function store(Request $request)
    {
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles_*[0-9]'])->get();
        foreach($keys as $param){
            Cache::forget($param->key);
        }
        Gate::authorize('create', Article::class);
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|min:10',
            'text' => 'max:100'
        ]);
        $article = new Article;
        $article->date_public = $request->date;
        $article->title = request('title');
        $article->text = $request->text;
        $article->user_id = auth()->id();
        if ($article->save()){
            NewArticleEvent::dispatch($article);
        }
        return redirect()->route('article.index')->with('message','Create successful');
    }

    public function show(Article $article)
    {
        if(isset($_GET['notify'])) auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        $comments = Cache::rememberForever('comments'.$article->id, function()use($article){
            return Comment::where('article_id', $article->id)
                            ->where('accept', true)
                            ->get();
        });
        return view('article.show', ['article' => $article, 'comments' => $comments]);
    }

    public function edit(Article $article)
    {
        Gate::authorize('restore', $article);
        return view('article.edit', ['article'=>$article]);
    }

    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|min:10',
            'text' => 'max:100'
        ]);
        $article->date_public = $request->date;
        $article->title = request('title');
        $article->text = $request->text;
        $article->user_id = auth()->id();
        if($article->save()){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles_*[0-9]'])->get();
            foreach($keys as $param){
                Cache::forget($param->key);
            }
        }
        return redirect()->route('article.show', ['article'=>$article->id])->with('message','Update successful');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);
        if($article->delete()){
            Cache::forget('comments'.$article->id);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles_*[0-9]'])->get();
            foreach($keys as $param){
                Cache::forget($param->key);
            }
        }
        return redirect()->route('article.index')->with('message','Delete successful');
    }
}
