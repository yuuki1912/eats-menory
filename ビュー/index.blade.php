<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>メインページ</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <p class="navbar-brand">
                    Eat Memory
                </p>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">新規登録</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('eats.myPage', ['user_id' => Auth::id()]) }}">マイページ</a></li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        ログアウト
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                <li class="nav-item">
                                    <a href="{{ route('eats.create') }}" class="btn btn-primary">投稿</a>
                                </li>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>投稿一覧</h1>
                    <div class="card text-center">
                        <div class="card-header">
                            Eat Memory
                        </div>
                        @foreach ($posts as $post)
                        <div class="card-body">
                            <h5 class="card-title">タイトル：{{ $post->title }}</h5>
                            <p class="card-text">投稿内容：{{ $post->body }}</p>
                            <p class="card-text">投稿者：{{ $post->user->name }}</p>
                            <a href=" {{ route('eats.show', $post->id) }} " class="btn btn-primary">詳細</a>
                            <div class="row justify-content-center">
                                <like-component :post="{{ json_encode($post) }}"></like-component>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            投稿日：{{ $post->created_at }}
                        </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
