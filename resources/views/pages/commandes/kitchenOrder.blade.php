
<!--Page commande de cuisinier-->

@extends(( auth()->user()->role == 'customer' ) ? 'layouts.app' : 'layouts.backend' )

@section('title', config('app.name'). ' - commande cuisinier')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'kitchenOrder' }}
@endsection

@section('navTheme')
{{ 'light' }}
@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}
@endsection


@section('content')
@if (!$firstOrder)

<section class="empty-order min-vh-100 flex-center pt-5">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">Pas de commande.</h3>
        <p class="text-muted">Pas de commande en attentes pour le moment</p>
        <div class="d-flex mt-3">
            <a href="{{ route('previousOrder') }}" class="primary-btn mx-3">Commande précédente</a>
            <a href="{{ route('dashboard') }}" class="primary-btn mx-3">Voir le tableau de bord</a>
        </div>
    </div>
</section>
@else

<section class="first-order d-flex">
    <div class="container">
        <div class="order-metadata mb-4">
            <div class="d-flex">
                <h2>Commande #{{ $firstOrder->id }}</h2>
                @if ($firstOrder->completed)
                <div class="mx-5 px-3 alert alert-success">
                    Valider
                </div>
                @else
                <div class="mx-5 px-3 alert alert-warning">
                   En attente
                </div>
                @endif
            </div>
            <div class="d-flex">
                <p class="text-muted">{{ $firstOrder->getOrderDate() }}</p>
                <p class="px-3 text-muted">{{ $firstOrder->getOrderTime() }}</p>
            </div>
        </div>

        <div class="order-cart p-4 mb-5">
            <h3 class="pb-4 px-2">Panier utilisateur</h3>
            <div class="flex-center flex-column order-cart-items">
            @foreach ($firstOrder->cartItems as $orderItem)
                <div class="order-cart-item d-flex justify-content-around">
                    <div class="food-img-wrapper">
                        <img src="{{ asset('menuImages/' . $orderItem->menu->image) }}" class="order-food">                      
                    </div>
                    <div class="food-desc-wrapper">
                        <div class="d-flex justify-content-between">
                            <h5>{{ $orderItem->menu->name }}</h5>
                            <div class="food-status-wrapper">
                            @if ($orderItem->fulfilled)
                                <form action="{{ route('orderStatusUpdate', $orderItem->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button class="primary-btn px-3 unfulfill">En attente</button>
                                </form>
                            @else
                                <form action="{{ route('orderStatusUpdate', $orderItem->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button class="primary-btn px-3 fulfill">Valider</button>
                                </form>                                
                            @endif
                            </div>
                        </div>
                        <div class="mobile d-flex pt-2">
                            <p class="price">{{ number_format($orderItem->menu->prix, 2) }}</p>
                            <p class="quantity">x{{ $orderItem->quantite }}</p>
                            <p class="cart-item-total">{{ number_format($orderItem->menu->prix * $orderItem->quantite, 2) }} fcfa</p>        
                        </div>
                        <p class="text-muted desktop w-75">{{ $orderItem->menu->description }}</p>
                    </div>
                    <p class="price desktop">{{ number_format($orderItem->menu->prix, 2) }} fcfa</p>
                    <p class="quantity desktop">x{{ $orderItem->quantite }}</p>
                    <p class="cart-item-total desktop">{{ number_format($orderItem->menu->prix * $orderItem->quantite, 2) }} fcfa</p>
                </div>
                <hr>
            @endforeach
            </div>
        </div>

        @if (!$activeOrders->count())
        <div class="d-flex justify-content-center">
            <a href="{{ route('previousOrder') }}" class="primary-btn">Commandes précédentes</a>
        </div>
        @endif

    </div>
</section>
@endif

@if ($activeOrders->count())
<section class="kitchen-active-orders">
    <div class="container">
        <h2 class="mb-4">Commande active</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Id commande</th>
                    <th scope="col">Date</th>
                    <th scope="col">Heure</th>
                    <th scope="col">Prix totaux</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeOrders as $order)
                    @if ($firstOrder->id == $order->id)
                    <tr class="table-active">
                    @else
                    <tr>
                    @endif
                        <th scope="row"><a href="{{ route('specificOrder', $order->id) }}">#{{ $order->id }}</a></th>
                        <td>{{ $order->getOrderDate() }}</td>
                        <td>{{ $order->getOrderTime() }}</td>
                        <td>{{ $order->getTotalFromScratch() }} fcfa</td>
                        <td>
                            @if ($order->completed)
                                <div class="px-3 alert alert-success">
                                    Valider
                                </div>  
                            @else
                                <div class="px-3 alert alert-warning">
                                    En attente
                                </div>  
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-5 d-flex justify-content-between">
            <a href="{{ route('previousOrder') }}" class="primary-btn">Commandes précédentes</a>
            {{ $activeOrders->links() }}
        </div>
    </div>
</section>
@endif
@endsection