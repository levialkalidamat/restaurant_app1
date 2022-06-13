<!--Page d'édition des plats-->

@extends(( auth()->user()->role == 'customer' ) ? 'layouts.app' : 'layouts.backend' )

@section('title', config('app.name'). ' - edition infos plats')

@section('links')
<link href="{{ asset('css/menu.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection

@section('bodyID')
{{ 'menu' }}
@endsection

@section('navTheme')
{{ 'light' }}
@endsection

@section('logoFileName')
{{ URL('http://127.0.0.1:8000/images/logo.jpg') }}
@endsection

@section('content')
<form method='post' action="{{ route('updateMenuDetails') }}" class="px-4 py-3" style="min-width: 350px">
    @csrf
    <input name="menuID" type="hidden" value="{{ $menu['id'] }}">

    <div class="mb-2">
        <label for="ItemType" class="form-label">Catégorie du plat</label>
        <div class="input-group mb-3">
            <label class="input-group-text" for="itemTypeInputGroup">Catégorie:</label>
            <select name="menuType" class="form-select" id="itemTypeInputGroup" >
                <option selected>{{ $menu['type'] }}</option>
                <option name="menuType" value="Aperitif">Aperitif</option>
                <option name="menuType" value="Dejeuner">Dejeuner</option>
                <option name="menuType" value="Diner">Diner</option>
                <option name="menuType" value="Repas">Repas</option>
                <option name="menuType" value="Nord">Nord</option>
                <option name="menuType" value="Sud">Sud</option>
                <option name="menuType" value="Dessert">Dessert</option>
            </select>
        </div>
    </div>
    
    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemName" class="form-label">Nom du plat</label>
        <div class="input-group mb-3">
            <input name="menuName" type="text" class="form-control" placeholder="Name" aria-label="Item Name" value="{{ $menu['nom'] }}" required>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemPrice" class="form-label">Prix du plat</label>
        <div class="input-group mb-3">
            <span class="input-group-text">Fcfa</span>
            <input name="menuPrice" type="number" min=0 step=0.01 class="form-control price-class" class="form-control" placeholder="Price" aria-label="Item Price" value="{{ $menu['prix'] }}" required>
            <span class="validity"></span>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemCost" class="form-label">Cout estimé</label>
        <div class="input-group mb-3">
            <span class="input-group-text">Fcfa</span>
            <input name="menuEstCost" type="number" min=0 step=0.01 class="form-control price-class" class="form-control" placeholder="Cost" aria-label="Item Cost" value="{{ $menu['coutEstime'] }}" required>
            <span class="validity"></span>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemDescription" class="form-label">Description du plat</label>
        <div class="input-group mb-3">
            <textarea name="menuDescription" class="form-control" placeholder="Description" aria-label="Item Description" required>{{ $menu['description'] }}</textarea>
        </div>
    </div>

    <div class="dropdown-divider"></div>
    
    <div class="mb-2">
        <label for="ItemSize" class="form-label">Nombre de personne</label>
        <div class="input-group mb-3">
            <label class="input-group-text" for="itemSizeInputGroup">Nombre:</label>
            <select name="menuSize" class="form-select" id="itemSizeInputGroup">
                <option selected>{{ $menu->nombre }}</option>
                @if($menu['nombre'] == "1-2")
                @else
                    <option name="menuSize" value="1-2">01 - 02 Personnes</option>
                @endif
                @if($menu['nombre'] == "3-4")
                @else
                    <option name="menuSize" value="3-4">03 - 04 Personnes</option>
                @endif
                @if($menu['nombre'] == ">5")
                @else
                    <option name="menuSize" value=">5">Plus de 05 Personnes</option>
                @endif
            </select>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="SpecialCondition" class="form-label">Condition </label>
        <div class="form-check">
            <input name="menuAllergic" type="hidden" value=0>

            @if( $menu['allergique'] == 1)
            <label class="form-check-label active" for="dropdownCheck">
                <input name='menuAllergic' value=1 type="checkbox" class="form-check-input" id="dropdownCheck" checked="checked">Allergique
            </label>
            @else
            <input name='menuAllergic' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
            <label class="form-check-label" for="dropdownCheck">
            Allergic
            </label>
            @endif
        </div>
        <div class="form-check">
            <input name="menuVegetarian" type="hidden" value=0>

            @if( $menu['vegetarien'] == 1)
            <label class="form-check-label active" for="dropdownCheck">
                <input name='menuVegetarian' value=1 type="checkbox" class="form-check-input" id="dropdownCheck" checked="checked">Vegetarien
            </label>
            @else
            <input name='menuVegetarian' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
            <label class="form-check-label" for="dropdownCheck">
            Vegetarien
            </label>
            @endif
        </div>
    </div>

    <div class="dropdown-divider"></div>
    <div class="row">
        <div>
            <button type="submit" class="btn btn-outline-success">Sauvegarder les changements</button>
            <a href={{ url()->previous() }}><button type="button" class="btn btn-outline-danger">Retour</button></a>
        </div>
    </div>
</form>
@endsection