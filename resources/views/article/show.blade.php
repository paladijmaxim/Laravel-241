@extends('layout')
@section('content')

@if(session()->has('message'))
  <div class="alert alert-success" role="alert">
      {{session('message')}}
  </div>
@endif

<div class="card" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title text-center">{{$article->title}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$article->date_public}}</h6>
    <p class="card-text">{{$article->text}}</p>
    @can('create')
    <div class="btn-toolbar mt-3" role="toolbar">
    <a href="/article/{{$article->id}}/edit" class="btn btn-primary me-3">Edit article</a>
    <div>
        <form action="/article/{{$article->id}}" method="post">
            @METHOD('DELETE')
            @CSRF
            <button type='submit' class = 'btn btn-warning me-3'>Delete article</button>
        </form>
    </div>
    @endcan
    <a href="{{ route('comments.create', $article) }}" class="btn btn-success">Добавить комментарий</a>
  </div>
</div>
<h3>Комментарии</h3>
@if($article->comments->count() > 0)
        @foreach($article->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $comment->user->name }} - 
                            {{ $comment->created_at->format('d.m.Y H:i') }}
                        </h6>
                        @auth
                            @can('comment', $comment)
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('comments.edit', $comment) }}" 
                                       class="btn btn-outline-primary">Редактировать</a>
                                    <form action="{{ route('comments.destroy', $comment) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Удалить комментарий?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Удалить</button>
                                    </form>
                                </div>
                            @endcan
                        @endauth
                    </div>
                    <p class="card-text mt-2">{{ $comment->text }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p>Пока нет комментариев.</p>
    @endif
@endsection