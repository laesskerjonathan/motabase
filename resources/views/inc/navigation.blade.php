@yield('navigation')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="/">
            <img id="logo" src="img/LogoNeu.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        {!! Form::open([
            'route'=>['search'],
            'method'=>'get']) !!}
            <div class="form-inline my-2 my-lg-0">
                {!! Form::text('search', null, ['placeholder'=>'Search here...', 'class'=>'form-control mr-sm-2', 'id'=>'search-input' ]) !!}
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </div>
        {!! Form::close() !!}
        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::segment(1) === 'movies' ? 'active' : null }}">
              <a class="nav-link" href="/movies">Movies <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item {{ Request::segment(1) === 'actors' ? 'active' : null }}">
              <a class="nav-link" href="/actors">Actors</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
      </div>
    </nav>