
<!--Page création de code de remise-->

@extends('layouts.backend')

@section('title', config('app.name'). ' - Création code réduction')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'previousOrder' }}
@endsection

@section('navTheme')
{{ 'light' }}
@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}
@endsection

@section('content')
<section class="min-vh-100 flex-center py-5">
    <div class="container">
        <h2 class="d-flex justify-content-center mt-5 mb-3">Creer code de remise(rabais)</h2>
        <form action="{{ route('createDiscount') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="discountCode" class="form-label">Code de remise</label>
            <input type="text" class="form-control @error('codeRemise') is-invalid @enderror" 
                id="discountCode" name="codeRemise" value="{{ old('codeRemise') }}">
            <div id="emailHelp" class="form-text">Nb: le code de réduction doit être unique</div>
            @error('codeRemise')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Pourcentage de remise (%)</label>
            <input type="number" class="form-control @error('pourcentage') is-invalid @enderror" 
                id="percentage" name="pourcentage" min="1" max="100" value="{{ old('pourcentage') }}">
            @error('pourcentage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="minSpend" class="form-label">Depense minimale fcfa</label>
            <input type="number" class="form-control @error('soldeMin') is-invalid @enderror" id="minSpend" 
                name="soldeMin" step=".01" value="{{ old('soldeMin') }}">
            @error('soldeMin')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cap" class="form-label">Dépense maximale fcfa</label>
            <input type="number" class="form-control @error('soldeMax') is-invalid @enderror" 
                id="cap" name="soldeMax" min="0" max="20000" step=".01" value="{{ old('soldeMax') }}">
            @error('soldeMax')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="startDate" class="form-label pe-5">Date de début</label>
            <input type="date" class="form-control @error('dateDebut') is-invalid @enderror" 
                name="dateDebut" value="{{ old('dateDebut') }}">
            @error('startDate')
                <span class="invalid-feedback" style="display:block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="endDate" class="form-label pe-5">Date de fin</label>
            <input type="date" class="form-control @error('dateFin') is-invalid @enderror" 
                name="dateFin" value="{{ old('dateFin') }}">
            @error('dateFin')
                <span class="invalid-feedback" style="display:block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description du code</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" 
                style="height: 100px" value="{{ old('description') }}"></textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="primary-btn">Creer code</button>
        </form>
    </div>
</section>
@endsection