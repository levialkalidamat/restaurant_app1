@extends('layouts.app')

@section('title', config('app.name'). ' - erreur 404')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'order' }}
@endsection

@section('navTheme')
{{ 'light' }}
@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}
@endsection


@section('content')
<section class="empty-order min-vh-100 pt-5 flex-center">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">404</h3>
        <p class="text-muted">Cette page n'existe pas</p>
        @guest
            <a href="{{ route('home') }}" class="primary-btn mt-3 py-2 px-3 rounded">Acceuil</a>
        @else
            @if (auth()->user()->role == 'customer')
            <a href="{{ route('home') }}" class="primary-btn mt-3 py-2 px-3 rounded">Acceuil</a>
            @else
            <a href="{{ route('dashboard') }}" class="primary-btn mt-3 py-2 px-3 rounded">Dashboard</a>
            @endif
        @endguest
    </div>
</section>
@endsection