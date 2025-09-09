@extends('layout')
@section('content')
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">{{$contact['name']}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$contact['address']}}</h6>
    <a href="#" class="card-link">{{$contact['email']}}</a>
    <a href="#" class="card-link">{{$contact['phone']}}</a>
  </div>
</div>
@endsection