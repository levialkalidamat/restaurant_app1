
<!--Page du panier -->

@extends('layouts.app')

@section('title', config('app.name'). ' - Panier')

@section('links')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'cart' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}@endsection


@section('content')
<section class="cart" style="margin-top: 20vh;">
    <div class="container">
        <h2 class="d-flex justify-content-center">Panier</h2>

        @if (session('success'))
        <div class="alert alert-success fixed-bottom" role="alert" style="width:500px;left:30px;bottom:20px">
            {{ session('success') }}
        </div>
        @elseif (session('error'))
        <div class="alert alert-warning fixed-bottom" role="alert" style="width:500px;left:30px;bottom:20px">
            {{ session('error') }}
        </div>
        @endif
        @if ($cartItems->count())

            <div class="container py-5">
                <div class="card col-md-6 col-12 offset-md-3">
                    <div class="card-body">
                        <h4 class="card-title mb-5 mx-2">Liste <span class="text-secondary h5">- {{ $cartItems->count() }} plats</span></h4>

                        @foreach ($cartItems as $item)
                            <div class="w-100 px-3 d-flex align-items-center py-3">
                                <div class="col-2">
                                    <img src="{{ asset('menuImages/' . $item->menu->image) }}" alt="cart item image" class="img-fluid">
                                </div>
                                <div class="col-6 px-4">
                                    <h5 class="text-dark">{{ $item->menu->nom }}</h5>
                                    <h5 class="text-secondary">{{ $item->menu->prix * $item->quantite }} fcfa</h5>
                                </div>
                                <div class="col-4 d-flex align-items-baseline justify-content-end">
                                    
                                    <form action="{{ route('cartUpdate', $item) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="cartAction" value="-">
                                        <button type="submit" class="btn btn-outline-secondary">-</button>
                                    </form>
                                   
                                    <h5 class="mx-4">{{ $item->quantite }}</h5>
                                    
                                    <form action="{{ route('cartUpdate', $item) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="cartAction" value="+">
                                        <button type="submit" class="btn btn-outline-secondary">+</button>
                                    </form>   
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between px-3 mt-5">
                            <h5 class="text-dark">Somme total</h5>
                            <h5 class="text-dark">{{ $subtotal }} fcfa</h5>
                        </div>

                        <!-- Partie payment -->
                        <form action="{{ route('cartCheckout') }}" method="post">
                            @csrf
                            <div class="d-flex flex-column px-3 mt-5 col-12 align-items-center">
                                <h5 class="text-secondary">Code de remise</h5>
                                <input type="text" class="form-control mt-3" name="discountCode" id="discountCode" placeholder="Placer votre code de remise ici ...">
                            </div>

                            <h5 class="text-secondary mt-5 text-center">Date et heure de commande</h5>
                            <div class="d-flex flex-column mt-4 px-3">
                                <!-- Selectionner la date et heure de commande -->
                                <!-- Verification de la validation -->
                                <input class="form-control @error('dateTime') is-invalid @enderror" 
                                name="dateTime" type="datetime-local" value="{{ old('dateTime') }}" required>
                                @error('dateTime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- dinner ou autre chose -->
                            <h5 class="text-secondary mt-5 text-center">Type de commande</h5>
                            <div class="d-flex justify-content-center mt-4">
                                <div class="form-check form-check-inline">
                                    <input value="diner" class="form-check-input @error('type') is-invalid @enderror h5" type="radio" name="type" id="dineInRadio">
                                    <label class="form-check-label" for="dineInRadio">
                                        Pour le diner
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input value="autreChose" class="form-check-input @error('type') is-invalid @enderror h5" type="radio" name="type" id="takeAwayRadio">
                                    <label class="form-check-label" for="takeAwayRadio">
                                        Pour autre chose 
                                    </label>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--Verification-->
                            <button type="submit" class="primary-btn mt-5 w-100">Verification</button>
                        </form>
                        <!-- fin v??rification-->
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <div class="col-md-4 col-8">
                    <div class="col-12 mt-5 d-flex align-items-baseline">
                        <div class="col-2 px-2">
                            <img src="./images/cart.svg" alt="cart" class="img-fluid">
                        </div>
                        <div class="col-10">
                            <h4 class="m-3">Panier vide</h4>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <p class="h5">Votre panier est vide pour le moment. <span><a href="{{ route('menu') }}" class="h5"><u>Ajouter un plat au panier maintenant</u></a></span></p>
                    </div>
                    <div class="col-12 mt-4">
                        <a href="{{ route('menu') }}"><button class="primary-btn w-100 py-2">Voire les plats</button></a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection