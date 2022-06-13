@extends('layouts.backend')

@section('title', config('app.name'). ' - tableau de bord')

@section('links')
    <script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>
@endsection

@section('bodyID')
{{ 'Dashboard' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}@endsection


@section('content')


<section class="container">
    <div class="row mt-5">
        <div class="col mt-lg-0 mt-5">
            <h1 class="mt-lg-0 mt-3">Tableau de bord</h1>
        </div>
        <div class="col-lg-5 col-12 d-flex justify-content-center mt-lg-0 mt-5">
            <div class="col-11 flex-center py-2 shadow rounded bg-white">
            <div class="flex-center">
            <img src="{{ URL::asset('/images/calendar.svg') }}" style="height: 32px; width: 32px;">
            </div>
            <p class="flex-center mt-lg-0 px-3">Depuis: {{ $startDate }}</p>
            <p class="flex-center mt-lg-0 px-3">a: {{ $today }} </p>
            </div>
        </div>
    </div>
    
       
    <!-- première ligne -->
    <div class="row mt-5 justify-content-center">
        <div class="col-lg-4 col-12 mb-lg-0 mb-3 flex-center">
            <div id="orders" class="col-11 p-3 h-100 shadow rounded bg-white"> 
                <h5 class="text-center">Commandes totales</h5>
                <h2 class="my-4 fw-bold text-center">{{ $totalOrders }}</h2>
            </div>
        </div>
        <div class="col-lg-4 col-12 mb-lg-0 mb-3 flex-center">
            <div id="code-usage" class="col-11 p-3 h-100 shadow rounded bg-white">     
                <h5 class="text-center">Utilisation du code de réduction</h5>
                <h2 class="my-4  fw-bold text-center">{{ $discountCodeUsed }} fois</h2>
            </div>
        </div>
        <div class="col-lg-4 col-12 mb-lg-0 mb-3 flex-center">
            <div id="customers" class="col-11 p-3 h-100 shadow rounded bg-white">    
                <h5 class="text-center">Nombre d'utilisateur</h5>
                <h2 class="my-4 fw-bold text-center">{{ $numCustomer }}</h2>
            </div>
        </div>
    </div>    
</section>

@endsection