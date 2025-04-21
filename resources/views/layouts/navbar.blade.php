<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="{{asset('assets/front/img/logo.png') }}" alt="Vr-Shop" class="navbar-logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('home') }}">Главная <span class="sr-only">(current)</span></a>
        </li>
        @foreach($categories as $category)
        <li class="nav-item">
          <a class="nav-link" href="{{ route('categories.show' , ['slug' => $category->slug]) }}">{{ $category->title }}</a>
        </li>
        @endforeach
        <li class="nav-item">
          <button onclick="getCart('{{ route('cart.show') }}')" type="button" class="btn cart-btn">
            <i class="fas fa-shopping-cart mr-1"></i>
            Корзина
            <span class="badge badge-light mini-cart-qty ml-1">{{ session('cart_qty') ?? 0 }}</span>
          </button>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        @if (Route::has('login'))
        @auth
        @if (auth()->user()->email === 'tolyshimarev@gmail.com')
        <li class="navbar-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
        </li>
        @endif
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