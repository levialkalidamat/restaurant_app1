
<!--Page modification du code de remise-->

@extends('layouts.backend')

@section('title', config('app.name'). ' - edition code remise')

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
<section class="min-vh-100 flex-center py-5">
    <div class="container">
        <h2 class="d-flex justify-content-center mt-5 mb-3">Code de remise 
            <span class="ps-3 fw-bold fst-italic">{{ $discount->codeRemise }}</span>
        </h2>
        <form action="{{ route('discountUpdate', $discount->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="discountCode" class="form-label">Code de remise</label>
            <input type="text" class="form-control @error('codeRemise') is-invalid @enderror" id="discountCode" 
                name="codeRemise" value="{{ old('codeRemise') ? old('codeRemise') : $discount->codeRemise }}">
            <div id="emailHelp" class="form-text">Nb: le code de remise doit être unique.</div>
            @error('codeRemise')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Pourcentage du remise (%)</label>
            <input type="number" class="form-control @error('pourcentage') is-invalid @enderror" id="percentage" 
                name="pourcentage" min="1" max="100" value="{{ old('pourcentage') ? old('pourcentage') : $discount->pourcentage }}">
            @error('pourcentage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="minSpend" class="form-label">Depense minimale (fcfa)</label>
            <input type="number" class="form-control @error('soldeMin') is-invalid @enderror" id="minSpend" 
                name="soldeMin" step=".01" value="{{ old('soldeMin') ? old('soldeMin') : $discount->soldeMin }}">
            @error('soldeMin')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cap" class="form-label">Depense maximale (fcfa)</label>
            <input type="number" class="form-control @error('soldeMax') is-invalid @enderror" id="cap" name="soldeMax" 
                min="0" max="20000" step=".01" value="{{ old('soldeMax') ?  old('soldeMax') : $discount->soldeMax }}">
            @error('soldeMax')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="startDate" class="form-label pe-5">Date de début</label>
            <input type="date" class="form-control @error('cap') is-invalid @enderror" name="dateDebut" 
                value="{{ old('dateDebut') ? old('dateDebut') : $discount->dateDebut }}"> 
            @error('dateDebut')
                <span class="invalid-feedback"  style="display:block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="endDate" class="form-label pe-5">Date de fin</label>
            <input type="date" class="form-control @error('cap') is-invalid @enderror" 
                name="dateFin" value="{{ old('dateFin') ? old('dateFin') : $discount->dateFin }}">
            @error('dateFin')
                <span class="invalid-feedback" style="display:block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description du code</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description"
            style="height: 100px;">{{ old('description') ? old('description') : $discount->description }}
            </textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="primary-btn w-100">Mettre à jour</button>
    </form>
        
        <form class="mt-3" action="{{ route('discountDestroy', $discount->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="primary-btn w-100">Supprimer</button>
        </form>
    </div>
</section>
@endsection