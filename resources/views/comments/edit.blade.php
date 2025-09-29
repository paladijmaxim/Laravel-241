@extends('layout')
@section('content')

<h1>Редактирование комменатрия</h1>
<form action="{{ route('comments.update', $comment) }}" method = "POST"> 
    @CSRF
    @method('PUT')
    <div class = "mb-3">
        <label for="exampleInputEmail1" class="form-label">Text</label>
        <textarea name="text" id="text" class="form-control" rows="5">{{ old('text', $comment->text) }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
</form>
@endsection