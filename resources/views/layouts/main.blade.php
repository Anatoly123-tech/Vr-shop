<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0 maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield('title', 'Vr-Shop Auth')</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{asset('assets/front/img/logo.png') }}" alt="Vr-Shop" class="navbar-logo" width="50">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">Главная <span class="sr-only"></span></a>
              </li>
            </ul>
      
            <ul class="navbar-nav ml-auto">
              @if (Route::has('login'))
              @auth
              <li class="navbar-item">
                <a class="nav-link" href="#">{{ auth()->user()->name }}</a>
              </li>
              <li class="navbar-item">
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
              </li>
              @else
              <li class="navbar-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
              </li>
              <li class="navbar-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
              </li>
              @endif
              @endif
            </ul>
          </div>
        </div>
      </nav>
    <main class="main mt-3">
        <div class="container">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{session('success') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>



</body>

</html>



