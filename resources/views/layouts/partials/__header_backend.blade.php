<header>
        <nav data-theme="@yield('navTheme')" class="home-nav @yield('navTheme')">
            <a href="/" class="logo-wrapper">
                <img class="logo" src="@yield('logoFileName')" alt="logo">
                <h3 class="logo-name">{{ config('app.name') }}</h3>
            </a>
            <ul class="nav-links">
            @if (auth()->user()->role == 'admin')
                <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li><a href="{{ route('kitchenOrder') }}">Commandes</a></li>
                <li><a href="{{ route('menu') }}">Plats</a></li>
                <li><a href="{{ route('discount') }}">Code remise</a></li>
                <li><a href="{{ route('accountCreation') }}">Creer compte</a></li>
            @endif
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
</header>