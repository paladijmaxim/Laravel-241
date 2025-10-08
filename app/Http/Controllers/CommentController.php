<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\Commentmail;

class CommentController extends Controller
{
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
    if ($comment->save()) {
        Mail::to('paladijmaximmail@mail.ru')->send(new Commentmail($comment, $article));
    }
    return redirect()->route('article.show', $article)->with('success', 'Комментарий добавлен.');
}

    public function edit(Comment $comment){
        Gate::authorize('comment', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment){
        Gate::authorize('comment', $comment);
        $comment->update([
            'text' => $request->text
        ]);
        return redirect()->route('article.show', $comment->article_id)
            ->with('success', 'Комментарий обновлен!');
    }

    public function destroy(Comment $comment){
        Gate::authorize('comment', $comment);
        $comment->delete();
        return back()->with('success', 'Комментарий удален');
        }
}
