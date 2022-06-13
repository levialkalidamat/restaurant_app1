<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use File;


class MenuController extends Controller
{
    public function index() {
        $menus = Menu::get();
        return view('pages.plats.menu', compact('menus'));
    }

    /**
     * Store a newly created menu in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validation des entrées du user
        $request->validate([
            'menuName' => 'required',
            'menuDescription' => 'required',
            'menuPrice' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'menuEstCost' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'menuSize' => 'required',
            'menuImage' => ['required', 'mimes:jpg,png,jpeg', 'max:10240'],//'required|mimes:jpg,png,jpeg|max:10240'
        ]);
        
        $newImageName = time() . '-' . $request->menuName . '.' .
        $request->menuImage->extension();
        $request->menuImage->move(public_path('menuImages'), $newImageName);

        // Création des plats et sauvegarde dans BD
        $newMenuItem = new Menu();
        $newMenuItem->type = $request->menuType;
        $newMenuItem->nom = $request->menuName;
        $newMenuItem->description = $request->menuDescription;
        $newMenuItem->prix = $request->menuPrice;
        $newMenuItem->coutEstime = $request->menuEstCost;
        $newMenuItem->image = $newImageName;
        $newMenuItem->nombre = $request->menuSize;
        $newMenuItem->allergique = $request->menuAllergic;
        $newMenuItem->vegetarien = $request->menuVegetarian;
        //$newMenuItem->vegan = $request->menuVegan;
        $newMenuItem->save();
        
        return redirect('/menu/filter?menuType=');
    }

    // Afficher les détails du plat
    public function showDetails($id)
    {
        $menu = Menu::find($id);
        return view('pages.plats.editMenuDetails', ['menu' => $menu]);
    }

    // Afficher les détails sur image du plat
    public function showImages($id)
    {
        $menu = Menu::find($id);
        return view('pages.plats.editMenuImages', ['menu' => $menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDetails(Request $request)
    {
        // Validation des entrées du user
        $request->validate([
            'menuName' => 'required',
            'menuDescription' => 'required',
            'menuPrice' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'menuEstCost' => 'required|regex:/^\d+(\.\d{1,2})?/',
            'menuSize' => 'required',
        ]);
        
        // Mise à jour des détails sur le plat
        $menu = Menu::find($request->menuID);
        $menu->type = $request->menuType;
        $menu->nom = $request->menuName;
        $menu->description = $request->menuDescription;
        $menu->prix = $request->menuPrice;
        $menu->coutEstime = $request->menuEstCost;
        $menu->nombre = $request->menuSize;
        $menu->allergique = $request->menuAllergic;
        $menu->vegetarien = $request->menuVegetarian;
        //$menu->vegan = $request->menuVegan;
        $menu->save();

        return redirect()->route('menu');
    }

    public function updateImages(Request $request)
    {
        if($request->hasFile('menuImage'))
        {
            $menu = Menu::find($request->menuID);

            // validation entrée user
            $request->validate([
                'menuImage' =>['required', 'mimes:jpg,png,jpeg|max:10240'], //'required|mimes:jpg,png,jpeg|max:10240'
            ]);
            
            // suppression image original dans le dossier public/menuImages
            $imagePath = 'menuImages/' . $menu->image;

            if(File::exists($imagePath))
            {
                File::delete($imagePath);
            }


            // Sauvegarde locale des images dans le dossier storage/public/menuImages
            $newImageName = time() . '-' . $menu->nom . '.' .
            $request->menuImage->extension();

            $request->menuImage->move(public_path('menuImages'), $newImageName);


            $menu->image = $newImageName;
            $menu->save();
        }   
        return redirect()->route('menu');
    }

    // Filtre sur la recherche d'un plat
    public function filter(Request $request)
    {
        $menu = Menu::query();

        if($request->filled('menuType'))
        {
            $menu->where('type', $request->menuType);
        }

        if($request->filled('fromPrice'))
        {
            $menu->where('prix', '>=', $request->fromPrice);
        }

        if($request->filled('toPrice'))
        {
            $menu->where('prix', '<=', $request->toPrice);
        }

        if($request->filled('menuSize'))
        {
            $menu->where('nombre', $request->menuSize);
        }

        if($request->filled('menuAllergic'))
        {
            $menu->where('allergique', $request->menuAllergic);
        }

        if($request->filled('menuVegetarian'))
        {
            $menu->where('vegetarien', $request->menuVegetarian);
        }

        /*if($request->filled('menuVegan'))
        {
            $menu->where('vegan', $request->menuVegan);
        }*/

        return view('pages.plats.menu', [
            'menus' => $menu->get()
        ]);
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $menu = Menu::find($id);
        $imagePath = 'menuImages/' . $menu->image;
        // suppression de l'image dans le dossier public/menuImages
        if(File::exists($imagePath))
        {
            File::delete($imagePath);
        }

        $menu->delete();
        return redirect()->route('menu');
    }
}
