
<!--Page d'acceuil-->

@extends('layouts.app')

@section('title', config('app.name'). ' - acceuil')

@section('links')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'home' }}
@endsection

@section('navTheme')
{{ 'dark' }}
@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}
@endsection


@section('content')
<section class="banner">
    <div class="container">
        <div class="col-md-10 col-lg-8 details">
            <h1>Expérience d'une cuisize 100% camerounais</h1>
            <a href="{{ route('menu') }}" class="btn primary-btn" style="width:250px;">Voire les différents plats</a>
        </div>
    </div>
</section>

<section class="chefs">
    <div class="container">
        <h2 class="title flex-center">Nos cuisinier</h2>
        <div class="row justify-content-evenly align-items-center chefs-wrapper">
            <div class="card col-lg-3 col-md-8 col-10 mt-5">
                <div class="chef-img d-flex align-items-center justify-content-center">
                    <img src="./images/chef1.jpg" alt="">
                </div>
                <div class="chef-desc d-flex flex-column align-items-center justify-content-start">
                    <p class="chef-name">Jean claude</p>
                    <p class="chef-position">Chef cuisinier</p>
                </div>
            </div>
            <div class="card col-lg-3 col-md-8 col-10 mt-5">
                <div class="chef-img d-flex align-items-center justify-content-center">
                    <img src="./images/chef2.jpg" alt="">
                </div>
                <div class="chef-desc d-flex flex-column align-items-center justify-content-start">
                    <p class="chef-name">Bouba</p>
                    <p class="chef-position">Cuisinier</p>
                </div>
            </div>
            <div class="card col-lg-3 col-md-8 col-10 mt-5">
                <div class="chef-img d-flex align-items-center justify-content-center">
                    <img src="./images/chef3.jpg" alt="">
                </div>
                <div class="chef-desc d-flex flex-column align-items-center justify-content-start">
                    <p class="chef-name">Hamadou</p>
                    <p class="chef-position">Aide cuisinier</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact">
    <div class="container">
        <h2 class="title flex-center">Contactez-nous</h2>
        <div class="flex-center contact-wrapper">
        <div class="form-wrapper flex-center">
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Votre nom</label>
                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Votre adresse email</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Votre message</label>
                    <textarea class="form-control" id="message" style="height: 100px"></textarea>
                </div>
                <div class="w-100 flex-center">
                <a href="mailto:waila.restaurant@gmail.com" class="primary-btn msg-btn w-100 px-3 py-2 text-center rounded">
                    Envoyez le message
                </a>
                </div>
            </form>
        </div>

        </div>
    </div>
</section>
@endsection