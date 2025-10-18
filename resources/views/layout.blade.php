<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </head>
    <body>
        <header> 
                    <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/article">Article</a>
                    </li>
                    @can('article')
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/article/create">Create Article</a>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/comments">Comment moderation</a>
                    </li>
                    @endcan()
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/contact">Contacts</a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        New comments <span>{{auth()->user()->UnreadNotifications->count()}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(auth()->user()->unreadNotifications as $notify)
                        <li>for article: <a class="dropdown-item" href="{{route('article.show', ['article'=>$notify->data['article_id'],'notify'=>$notify->id])}}">{{$notify->data['article']}}</a></li>
                        @endforeach
                    </ul>
                    </li>
                    @endauth
                </ul>
                <div class="d-flex">
                @guest
                    <a href = '/auth/signin' class="btn btn-outline-success">SignIn</a>
                    <a href = '/auth/login' class="btn btn-outline-success">SignOut</a>
                @endguest
                    @auth
                    <a href = '/auth/logout' class="btn btn-outline-success">Exit</a>
                    @endauth
            </div>
                </div>
            </div>
            </nav>
        </header>
        <main>
            <div class = 'container mt-5'>
<div id="app">

</div>
                @yield('content')
            </div>
        </main>
    </body>

</html>
