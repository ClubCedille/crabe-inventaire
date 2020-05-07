<!DOCTYPE html>
<script src="/js/lang.js"></script>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'C.R.A.B.E.') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/bulma.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/crabe.css') }}" rel="stylesheet">
    </head>
    <body>
       
            <nav class="navbar navbar-expand-md navbar-dark bg-black shadow-sm">
                <div class="container ">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <strong class="text-white">
                            {{ config('app.name', 'C.R.A.B.E.') }}
                        </strong>
                    </a>
                    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            @if (Auth::check())
                            <li class="nav-item">
                                <form action="{{ route('cart') }}">
                                    <button  type="submit" value="go to cart" class="btn btn-outline-danger " >{{ __('cart.cart') }}</button>
                                </form>
                            </li>
                            @endif
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                                </li>
                            @endif
                            @else
                            @if (Auth::user()->isAdmin === 1)
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('category') }}">{{ __('auth.categoryList') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('product') }}">{{ __('auth.productList') }}</a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown text-white" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstName }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('auth.logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('receipts') }}">
                                        {{ __('auth.receipts') }}
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
          
                <main id="app" class="container">
                    @yield('content')
                </main>
           
    </body>
</html>
