<header>
        <nav data-theme="@yield('navTheme')" class="home-nav @yield('navTheme')">
            <a href="/" class="logo-wrapper">
                <img class="logo" src="@yield('logoFileName')" alt="logo">
                <h3 class="logo-name">{{ config('app.name') }}</h3>
            </a>
            <ul class="nav-links">
                <li><a href="/">Acceuil</a></li>
                <li><a href="{{ route('menu') }}">Plats</a></li>
                @guest
                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    <li><a href="{{ route('login') }}">Se connecter</a></li>
                @else
                    @if (auth()->user()->role == 'customer')
                    <li><a href="{{ route('cart') }}">Panier</a></li>
                    <li><a href="{{ route('order') }}">Commande</a></li>
                    @elseif (auth()->user()->role != 'customer')
                    <li><a href="{{ route('kitchenOrder') }}">Commander</a></li>
                    @if (auth()->user()->role == 'admin')
                    <li><a href="{{ route('discount') }}">Code remise</a></li>
                    @endif
                    @endif
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    </li>
                    <li style="color:blue; "><a> {{auth()->user()->username}}</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>