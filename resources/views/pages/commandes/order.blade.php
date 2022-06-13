<!--Page des commandes-->

@extends('layouts.app')

@section('title', config('app.name'). ' - commandes')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'order' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}@endsection


@section('content')
@if (!$activeOrder && !$allOrders->count())
<!-- Verification si le user n'a pas de commande auparavant -->
<section class="empty-order min-vh-100 pt-5 flex-center">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">Pas de commande pour le moment</h3>
        <p class="text-muted">Faite votre choix</p>
        
        <a href="{{ route('menu') }}"><button class="primary-btn mt-3">Découvrir les plats</button></a>
    </div>
</section>
@elseif ($activeOrder)
<section class="active-order d-flex">
    <div class="container">
        <div class="order-metadata mb-4">
            <div class="d-flex">
                <h2>Commande #{{ $activeOrder->id }}</h2>
                @if ($activeOrder->completed)
                <div class="mx-5 px-3 alert alert-success">
                    En attente
                </div>
                @else
                <div class="mx-5 px-3 alert alert-warning">
                    En attente
                </div>
                @endif
            </div>
            <div class="d-flex">
                <p class="text-muted">{{ $activeOrder->getOrderDate() }}</p>
                <p class="px-3 text-muted">{{ $activeOrder->getOrderTime() }}</p>
            </div>
        </div>

        <div class="row">
            <div class="order-cart p-4 mb-5 col-lg-8 col-md-12">
                <h3 class="pb-4 px-2">Vos commandes</h3>
                <div class="flex-center flex-column order-cart-items">
                @foreach ($activeOrder->cartItems as $orderItem)
                    <div class="order-cart-item d-flex justify-content-around">
                        <div class="food-img-wrapper">
                            <img class="order-food shadow" src="{{ asset('menuImages/' . $orderItem->menu->image) }}">
                        </div>
                        <div class="food-desc-wrapper">
                            <div class="d-flex justify-content-between">
                                <h5>{{ $orderItem->menu->nom }}</h5>
                                @if ($orderItem->status)
                                    <div class="px-3 alert alert-success">
                                        En attente
                                    </div>  
                                @else
                                    <div class="px-3 alert alert-warning">
                                        En attente
                                    </div>  
                                @endif
                            </div>
                            <div class="mobile d-flex pt-2">
                                <p class="price">{{ number_format($orderItem->menu->prix, 2) }} Fcafa</p>
                                <p class="quantity">x{{ $orderItem->quantite }}</p>
                                <p class="cart-item-total">{{ number_format($orderItem->menu->prix * $orderItem->quantite, 2) }} Fcfa</p>        
                            </div>
                            <p class="text-muted desktop">{{ $orderItem->menu->description }}</p>
                        </div>
                        <p class="price desktop">{{ number_format($orderItem->menu->prix, 2) }} Fcfa</p>
                        <p class="quantity desktop">x{{ $orderItem->quantite }}</p>
                        <p class="cart-item-total desktop">{{ number_format($orderItem->menu->prix * $orderItem->quantite, 2) }} Fcfa</p>
                    </div>
                    <hr>
                @endforeach
                </div>
            </div>

            <div class="order-summary p-4 col-lg-3 offset-lg-1 col-md-12">
                <h3 class="pb-3">Sommaire</h3>
                <div class="d-flex justify-content-between">
                    <h6>Somme Total</h6>
                    <p>{{ $subtotal = $activeOrder->getSubtotal() }} Fcfa</p>
                </div>
                <div class="d-flex justify-content-between">
                    <h6>Rabais</h6>
                    <p>{{ $discount = $activeOrder->getDiscount($subtotal) }} Fcfa</p>
                </div>
                <div class="d-flex justify-content-between">
                    <h6>Tax (6%)</h6>
                    <p>{{ $tax = $activeOrder->getTax($subtotal, $discount) }} Fcfa</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h6>Totaux</h6>
                    <p>{{ $activeOrder->getTotal($subtotal, $discount, $tax) }} Fcfa</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if ($allOrders->count())
@if(!$activeOrder)
<div class="pt-18vh">
@endif
<section class="order-histories">
    <div class="container">
        <h2 class="mb-4">Commandes précédentes</h2>
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
                @foreach ($allOrders as $order)
                @if ($activeOrder && $activeOrder->id == $order->id)
                <tr class="table-active">
                @else
                <tr>
                @endif
                    <th scope="row"><a href="{{ route('specificOrder', $order->id) }}">#{{ $order->id }}</a></th>
                    <td>{{ $order->getOrderDate() }}</td>
                    <td>{{ $order->getOrderTime() }}</td>
                    <td>{{ $order->getTotalFromScratch() }} Fcfa</td>
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
        <div class="row mt-md-4">
            <div class="col-12 flex-center">
                {{ $allOrders->links() }}
            </div>
        </div>
    </div>
</section>
@if(!$activeOrder)
</div>
@endif
@endif
@endsection