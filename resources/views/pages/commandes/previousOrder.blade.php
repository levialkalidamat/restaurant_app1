
@extends('layouts.backend')

@section('title', config('app.name'). ' - commandes précédentes')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'previousOrder' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}@endsection


@section('content')
@if (!$previousOrders->count())

<section class="empty-order min-vh-100 flex-center pt-5">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">Pas encore de commande.</h3>
        <p class="text-muted">Il ya pas de commande antérieur</p>
        <div class="d-flex mt-3">
            <a href="{{ route('kitchenOrder') }}" class="primary-btn mx-3">Commande en cours</a>
            <a href="{{ route('dashboard') }}" class="primary-btn mx-3">Voire le tableau de bord</a>
        </div>
    </div>
</section>
@else
<section class="kitchen-previous-orders min-vh-100 d-flex align-items-center mt-lg-0 mt-3">
    <div class="container mt-lg-0 mt-5">
        <h2 class="mt-5 mb-4">Commandes précédentes</h2>
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
                @foreach ($previousOrders as $order)
                    <tr>
                        <th scope="row"><a href="{{ route('specificKitchenOrder', $order->id) }}">#{{ $order->id }}</a></th>
                        <td>{{ $order->getOrderDate() }}</td>
                        <td>{{ $order->getOrderTime() }}</td>
                        <td>RM {{ $order->getTotalFromScratch() }}</td>
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
        <div class="my-md-5 mt-4 mb-5 d-flex flex-md-row flex-column justify-content-md-between">
            <a href="{{ route('kitchenOrder') }}" class="primary-btn">Commande en cours</a>
            <div class="col-md-8 col-12 d-flex justify-content-md-end justify-content-center">
            {{ $previousOrders->links() }}
            </div>
        </div>
    </div>
</section>
@endif
@endsection