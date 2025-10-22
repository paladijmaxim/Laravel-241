<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Jobs\VeryLongJob;
use App\Notifications\NewCommentNotify;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    public function index(){
        $page = (isset($_GET['page'])) ? $_GET["page"] : 0;
        $comments = Cache::rememberForever('comments_'.$page, function(){
        return Comment::latest()->paginate(10);
        });
        return view('comments.index', ['comments'=>$comments]);
    }

    public function create(Article $article)
    {
        return view('comments.create', compact('article'));
    }

    public function store(Request $request, Article $article)
{
    // $article = Article::FindOrFail($request->article_id);
    $request->validate([
        'text' => 'required|min:1|max:500'
    ]);
    $comment = new Comment([
        'text' => $request->text,
        'article_id' => $article->id,
        'user_id' => Auth::id(),
    ]);
    if($comment->save()){
        VeryLongJob::dispatch($article, $comment, auth()->user()->name);
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments_*[0-9]'])->get();
            foreach($keys as $param){
                Cache::forget($param->key);
            }
        }
    return redirect()->route('article.show', $article)->with('success', 'Комментарий добавлен.');
}

    public function edit(Comment $comment){
        Gate::authorize('comment', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment){
        Gate::authorize('comment', $comment);
        if($comment->save()){
            Cache::flush();
        }
        $comment->update([
            'text' => $request->text
        ]);
        return redirect()->route('article.show', $comment->article_id)
            ->with('success', 'Комментарий обновлен!');
    }

    public function destroy(Comment $comment){
        Gate::authorize('comment', $comment);
        if($comment->save()){
            Cache::forget('comments'.$comment->article_id);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments_*[0-9]'])->get();
            foreach($keys as $param){
                Cache::forget($param->key);
            }
        }
        $comment->delete();
        return back()->with('success', 'Комментарий удален');
        }

    public function accept(Comment $comment){
        $comment->accept = true; 
        $article = Article::findOrFail($comment->article_id);
        $users = User::where('id', '!=', $comment->user_id)->get();
        if ($comment->save()) {
            Notification::send($users, new NewCommentNotify($article->title, $article->id));
            Cache::forget('comments'.$article->id);
        };
        return redirect()->route('comment.index');
    }

    public function reject(Comment $comment){
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comment.index');
    }
}
