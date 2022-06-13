<!--page du plat-->

@extends(( !Auth::check() || auth()->user()->role == 'customer' ) ? 'layouts.app' : 'layouts.backend' )

@section('title', config('app.name'). ' - plats')

@section('links')
<link href="{{ asset('css/menu.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'menu' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/logo.jpg') }}@endsection


@section('content')
<section class="menu" style="margin-top: 17vh;">
    <div class="container">
        <a href={{"./filter?menuType="}} class="menu-title">
            <h2 class="d-flex justify-content-center menu-title">Plats</h2>
        </a>
        @if (session('success'))
        <div class="alert alert-success fixed-bottom" role="alert" style="width:500px;left:30px;bottom:20px">
            {{ session('success') }}
        </div>
        @endif

        <div class="row menu-bar">
        @if (Auth::check() && auth()->user()->role == 'admin')
            <div class="col-md-1 d-flex align-items-center">
                <div class="dropstart">    
                    <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" id="filter-button">
                        <i class="fa fa-plus" aria-hidden="true"></i></i>
                    </button>
                    <div class="dropdown-menu">    
                        <form method='post' action="{{ route('saveMenuItem') }}" enctype="multipart/form-data" class="px-4 py-3" style="min-width: 350px">
                            @csrf
                            <div class="mb-2">
                                <label for="formFile" class="form-label">Image du plat</label>
                                <input name="menuImage" class="form-control" type="file" id="item-image" required>
                            </div>
                            
                            <div class="dropdown-divider"></div>

                            <div class="mb-2">
                                <label for="ItemType" class="form-label">Categorie du plat</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="itemTypeInputGroup">Catégorie:</label>
                                    <select name="menuType" class="form-select" id="itemTypeInputGroup" >
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
                                    <input name="menuName" type="text" class="form-control" placeholder="Nom" aria-label="Item Name" required>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="mb-1">
                                <label for="ItemPrice" class="form-label">Prix du plat</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Fcfa</span>
                                    <input name="menuPrice" type="number" min=0 step=0.01 class="form-control price-class" placeholder="Prix" aria-label="Item Price" required>
                                    <span class="validity"></span>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="mb-1">
                                <label for="ItemCost" class="form-label">Cout estimé du plat</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Fcfa</span>
                                    <input name="menuEstCost" type="number" min=0 step=0.01 class="form-control price-class" placeholder="cout" aria-label="Item Cost" required>
                                    <span class="validity"></span>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="mb-1">
                                <label for="ItemDescription" class="form-label">Description du plat</label>
                                <div class="input-group mb-3">
                                    <textarea name="menuDescription" class="form-control" placeholder="Description" aria-label="Item Description" required></textarea>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>
                            
                            <div class="mb-2">
                                <label for="ItemSize" class="form-label">Nombre de personnes</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="itemSizeInputGroup">Nombre:</label>
                                    <select name="menuSize" class="form-select" id="itemSizeInputGroup" >
                                        <option name="menuSize" value="1-2">01 - 02 Personnes</option>
                                        <option name="menuSize" value="3-4">03 - 04 Personnes</option>
                                        <option name="menuSize" value=">5">Plus de 05 personnes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="mb-1">
                                <label for="SpecialCondition" class="form-label">Condition sur le plat</label>
                                <div class="form-check">
                                    <input name="menuAllergic" type="hidden" value=0>
                                    <input name='menuAllergic' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                    Allergique
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="menuVegetarian" type="hidden" value=0>
                                    <input name='menuVegetarian' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                    Vegetarien
                                    </label>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <button type="submit" class="btn btn-outline-success">Ajouter le plat</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::check() && auth()->user()->role == 'admin')
            <div class="col-md-8 offset-md-1 col-12 text-center menu-type my-3">
                <form method="get" action="{{ route('filterMenu') }}">
                    <button type="submit" name="menuType" value="" class="btn btn-light menu-type-button">Toutes les categories</button>
                    <button type="submit" name="menuType" value="Aperitif" class="btn btn-light menu-type-button">Aperitif</button>
                    <button type="submit" name="menuType" value="Dejeuner" class="btn btn-light menu-type-button">Dejeuner</button>
                    <button type="submit" name="menuType" value="Diner" class="btn btn-light menu-type-button">Diner</button>
                    <button type="submit" name="menuType" value="Repas" class="btn btn-light menu-type-button">Repas</button>
                    <button type="submit" name="menuType" value="Nord" class="btn btn-light menu-type-button">Nord</button>
                    <button type="submit" name="menuType" value="Sud" class="btn btn-light menu-type-button">Sud</button>
                    <button type="submit" name="menuType" value="Dessert" class="btn btn-light menu-type-button">Dessert</button>
                </form>
            </div>
        @else
            <div class="col-md-8 offset-md-2 col-12 text-center menu-type my-3">
                <form method="get" action="{{ route('filterMenu') }}">
                    <button type="submit" name="menuType" value="" class="btn btn-light menu-type-button">Toutes les categories</button>
                    <button type="submit" name="menuType" value="Aperitif" class="btn btn-light menu-type-button">Aperitif</button>
                    <button type="submit" name="menuType" value="Dejeuner" class="btn btn-light menu-type-button">Dejeuner</button>
                    <button type="submit" name="menuType" value="Diner" class="btn btn-light menu-type-button">Diner</button>
                    <button type="submit" name="menuType" value="Repas" class="btn btn-light menu-type-button">Repas</button>
                    <button type="submit" name="menuType" value="Nord" class="btn btn-light menu-type-button">Nord</button>
                    <button type="submit" name="menuType" value="Sud" class="btn btn-light menu-type-button">Sud</button>
                    <button type="submit" name="menuType" value="Dessert" class="btn btn-light menu-type-button">Dessert</button>
                </form>
            </div>
        @endif
            <div class="col-md-2 d-flex align-items-center">
                <div class="dropstart w-100 d-flex justify-content-end">    
                    <button type="button" class="btn btn-dark" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" id="filter-button">Filtrer <i class="fa fa-filter" aria-hidden="true"></i></button>
                    <div class="dropdown-menu">
                        <form method="get" action="{{ route('filterMenu') }}" class="px-4 py-3 " style="min-width: 350px">    
                            <div class="mb-2">
                                <label for="ItemType" class="form-label">Type de plat</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="itemTypeInputGroup">Catégorie:</label>
                                    <select name="menuType" class="form-select" id="itemTypeInputGroup" >
                                        <option name="menuType" value="">Toutes</option>
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
                        
                            <div class="col-12 mb-3">
                                <label for="PriceRange" class="form-label">Intervalle de prix</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Fcfa</span>
                                    <input name="fromPrice" type="text" class="form-control" placeholder="Prix de " aria-label="From Price">
                                    <span class="input-group-text">~</span>
                                    <input name="toPrice" type="text" class="form-control" placeholder="A" aria-label="To Price">
                                </div>
                            </div>
                            
                            <div class="dropdown-divider"></div>
                            

                            <div class="mb-2">
                                <label for="ItemSize" class="form-label">Nombre de personne</label>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="itemSizeInputGroup">Nombre:</label>
                                    <select name="menuSize" class="form-select" id="itemSizeInputGroup" >
                                        <option name="menuSize" value="">Tous</option>
                                        <option name="menuSize" value="1-2">01 - 02 Personnes</option>
                                        <option name="menuSize" value="3-4">03 - 04 Personnes</option>
                                        <option name="menuSize" value=">5">Plus de 05 Personnes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="mb-3">
                              <label for="SpecialCondition" class="form-label">Condition sur le plat</label>
                                <div class="form-check">
                                    <input name='menuAllergic' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                    Allergique
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name='menuVegetarian' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                    Vegetarien
                                    </label>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>
                            <button type="submit" class="btn btn-outline-dark">Chercher</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        


        <div class="d-flex flex-wrap mt-4 mb-5">
        @forelse ($menus as $menu)
            
            <div class="card col-md-3 col-6 d-flex align-items-center">
                <div class="card-body w-100">
                    <form class="d-flex flex-column justify-content-between h-100" action="{{ route('addToCart') }}" method="post">
                        @csrf
                        <div class="flex-center">
                            <img class="card-img-top menuImage" src="{{ asset('menuImages/' . $menu->image) }}">
                        </div>

                        <h5 class="card-title mt-3">
                            {{ $menu->nom }} 
                        </h5>
                        
                        <h6 class="card-subtitle mb-2 text-muted">{{ $menu->description }}</h6>
                        <h6 class="card-subtitle mb-2 text-muted">Pour {{ $menu->nombre }} Personnes</h6>
                        
                        <div class="d-flex justify-content-between">
                            <p class="card-text fs-5 fw-bold">{{ number_format($menu->prix, 2) }} Fcfa</p>
                            <h6 class="card-text flex-center">
                                @if($menu->allergique)
                                <i class="fa fa-exclamation-circle allergic-alert" aria-hidden="true" data-bs-toggle="tooltip" title="Allergic Warning"></i>
                                @endif
                                
                                @if($menu->vegetarien)
                                <i class="fa fa-leaf" aria-hidden="true" data-bs-toggle="tooltip" title="Vegetarian Friendly"></i>
                                @endif
                            </h6>
                        </div>

                        <input name="menuID" type="hidden" value="{{ $menu->id }}">
                        <input name="menuName" type="hidden" value="{{ $menu->nom }}">
                        @if (Auth::check())
                            @if (auth()->user()->role == 'customer')
                                <button type="submit" class="primary-btn w-100 mt-3">Ajouter au panier</button>
                            @elseif (auth()->user()->role == 'admin')
                                <div class="dropdown w-100 mt-3">
                                    <a href="#" role="button" id="dropdownMenuLink" 
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        <button class="primary-btn w-100">Editer</button>
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href={{"./editMenuImages/".$menu['id']}}>Modifier image</a></li>
                                        <li><a class="dropdown-item" href={{"./editMenuDetails/".$menu['id']}}>modifer les détails</a></li>
                                        <li><a class="dropdown-item" href={{"./delete/".$menu['id']}}>Supprimer le plat</a></li>
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </form>
                </div>
            </div>
        
        @empty
        <div class="row">
            <div class="col-12">
                <h1>Aucun plat disponible<i class="fa fa-frown-o" aria-hidden="true"></i></h1>
            </div>
        </div>
        @endforelse
        </div>
    </div>
</section>
@endsection