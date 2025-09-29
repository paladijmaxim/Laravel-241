@extends('layout')
@section('content')

<div class="container">
    <h2>Добавить комментарий к статье: "{{$article->title}}"</h2>
    
    <form action="{{ route('comments.store', $article) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label">Текст комментария:</label>
            <textarea name="text" id="text" class="form-control" rows="5" 
                      placeholder="Введите комментарий">{{old('text')}}</textarea>
            @error('text')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Добавить комментарий</button>
        <a href="{{ route('article.show', $article) }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>

@endsection