@extends('layouts.backend')

@section('title', config('app.name'). ' - code remise')

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
@if (!$discounts->count())
<section class="empty-order min-vh-100 flex-center pt-5">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">Pas encore de code de réduction.</h3>
        <p class="text-muted">Pas encore de code de réduction.</p>
        <div class="d-flex mt-3">
            <a href="{{ route('createDiscount') }}" class="primary-btn mx-3">Creer code de réduction</a>
        </div>
    </div>
</section>
@else
<section class="min-vh-100 d-flex align-items-start mt-5 pt-18vh">
    <div class="container">
        <div class="d-flex justify-content-between">
        <h2 class="mb-4">Code de réduction</h2>
        <a href="{{ route('createDiscount') }}" class="primary-btn">+ créer code reduction</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Pourcentage</th>
                    <th scope="col">Depense minimale</th>
                    <th scope="col">Cap</th>
                    <th scope="col">Date de début</th>
                    <th scope="col">Date de fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discounts as $discount)
                    <tr>
                        <th scope="row"><a href="{{ route('specificDiscount', $discount->id) }}">
                            {{ $discount->codeRemise }} </a></th>
                        <td>{{ $discount->pourcentage }}%</td>
                        <td>{{ number_format($discount->soldeMin, 2) }} Fcfa</td>
                        <td>{{ number_format($discount->soldeMax, 2) }} Fcfa</td>
                        <td>{{ $discount->dateDebut }}</td>
                        <td>{{ $discount->dateFin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>  
    </div>
</section>
@endif
@endsection