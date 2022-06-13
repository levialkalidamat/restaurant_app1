<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        var assetBaseUrl = "{{ asset('') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/backend.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/a94b89670e.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">

    <!--ajouter-->
    <link href="{{ asset('js/popper.min.js') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap.min.js') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap.bundle.min.js') }}" rel="stylesheet">

    @yield('links')

</head>
<body id="@yield('bodyID')">
    
    <!--Inclusion du header backend-->
    @yield('layouts.partials.__header_backend')

    <div class="sidebar">
        <header>
            <img id="logo" src="@yield('logoFileName')" alt="logo">
        </header>
        <ul>
        @if (auth()->user()->role == 'admin')
            <li ><a href="{{ route('dashboard') }}" id="sidebar-dashboard"><i class="fa fa-th-large" aria-hidden="true"></i>Tableau de bord</a></li>
            <br>
            <li ><a href="{{ route('kitchenOrder') }}" id="sidebar-orders"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Commandes</a></li>
            <br>
            <li ><a href="{{ route('menu') }}" id="sidebar-menu"><i class="fa fa-book" aria-hidden="true"></i>Plats</a></li>
            <br>
            <li ><a href="{{ route('discount') }}" id="sidebar-discount"><i class="fa fa-ticket" aria-hidden="true"></i>Code remise</a></li>
            <br>
            <li ><a href="{{ route('accountCreation') }}" id="sidebar-account"><i class="fa fa-user" aria-hidden="true"></i>Creer compte</a></li>
            <br>
        @else
            <li ><a href="{{ route('kitchenOrder') }}" id="sidebar-orders"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Commandes</a></li>
            <br>
        @endif
            <li >
                <a href="{{ route('logout') }}" id="sidebar-logout" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>{{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            
        </ul>
    </div>

    <div class="container">
        <div class="pl-250">
        @yield('content')
        </div>
    </div>
    
</body>
</html>