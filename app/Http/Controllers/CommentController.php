<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function create(Article $article)
    {
        return view('comments.create', compact('article'));
    }

    public function store(Request $request, Article $article){
        $request -> validate([
            'text' => 'required|min:1|max:500'
        ]);

        Comment::create([
            'text' => $request -> text,
            'article_id' => $article -> id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('article.show', $article)->with('success', 'Комментарий добавлен.');
    }

    public function edit(Comment $comment){
        Gate::authorize('comment', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment){
        if ($comment -> user_id !== Auth::id()){
            abort(403, 'Вы не можете редактировать комментарий(');
        };

        $request -> validate([
            'text' => 'required|min:1|max:500'
        ]);

        $comment -> update([
            'text' => $request -> text
        ]);

        return redirect()->route('article.show', $comment->article_id)
            ->with('success', 'Комментарий обновлен!');
    }

    public function destroy(Comment $comment){
        if ($comment -> user_id !== Auth::id()){
            abort(403, 'Вы не можете удалить комментарий(');
        };

        $comment -> delete();

        return back()->with('success', 'Комментарий удален');
        }
}
