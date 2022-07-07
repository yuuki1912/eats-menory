<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>詳細ページ</title>

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
                        <li class="nav-item"><a class="nav-link" href="{{ route('eats.index') }}">メインページ</a></li>
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
                    <h1>詳細ページ</h1>
                    <div class="card text-center">
                        <div class="card-header">
                            Eat Memory
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">タイトル：{{ optional($post)->title }}</h5>
                            <p class="card-text">投稿内容：{{ optional($post)->body }}</p>
                            <img src="{{ $post->image_path }}" alt="画像">
                            @if ( optional($post)->user_id === Auth::id() )
                            <div class="functionButtons">
                                <a href=" {{ route('eats.edit', $post->id) }} " class="btn btn-primary" id="editBtn">編集</a>
                                <form action='{{ route('eats.destroy', $post->id) }}' method='post'>
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type='submit' value='削除' class="btn btn-danger" onclick='return confirm("削除しますか？？");'>
                                </form>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer text-muted">
                            投稿日：{{ optional($post)->created_at }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="{{ route('comments.store') }}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="eats_id" value="{{ optional($post)->id }}">
                            <div class="form-group">
                                <label>コメント</label>
                                <textarea class="form-control" placeholder="内容" rows="5" name="body"></textarea>
                            </div>
                        <button type="submit" class="btn btn-primary">コメントする</button>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @foreach ($comments as $comment)
                    <div class="card mt-3">
                        <h5 class="card-header">投稿者：{{ $comment->user->name }}</h5>
                        <div class="card-body">
                            <h5 class="card-title">投稿日時：{{ $comment->created_at }}</h5>
                            <p class="card-text">内容：{{ $comment->body }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</body>
</html>
