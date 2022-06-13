<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Discount;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function currencyFormat($number) {
        return number_format((float)$number, 2, '.', '');
    }

    // Affichage du panier
    public function index() {
        if (auth()->user()->role != 'customer')
            abort(403, 'Cette route est réservé au utilisateur seulement.');
        
        $subtotal = 0;
        $cartItems = auth()->user()->cartItems->where('order_id', null);
        foreach($cartItems as $item) {
            $subtotal = $subtotal + ($item->menu->prix * $item->quantite);
        }
        
        return view('pages.panier.cart', compact('cartItems', 'subtotal')); 
    }

    // Ajout d'un plat au panier
    public function store(Request $request) {
        if (auth()->user()->role != 'customer')
            abort(403, 'Cette route est réservé au utilisateur seulement..');
        
        //dd('ok');
        auth()->user()->cartItems()->create([
            'menu_id' => $request->menuID,
            'quantite' => 1,
        ]);
        /*
        CartItem::create([
            'user_id' => auth()->user()->id,
            'menu_id' => $request->menuID,
            'quantite' => 1
        ]);*/
        

        return back()->with('success', "{$request->menuName} ajouté avec sussès au panier.");
    }

    // Modification de la quantité du plat dans le panier
    public function update(CartItem $cart, Request $request) {
        if (auth()->user()->role != 'customer')
            abort(403, 'Cette route est réservé au utilisateur seulement..');

        if ($request->cartAction == "-") {
            if ($cart->quantite > 1)
                $cart->quantite--;
            else {
                $dish = $cart->menu->nom;
                $cart->delete();
                return back()->with('success', "{$dish} supprimé avec succès du panier.");
            }
        } else if ($request->cartAction == "+")
            $cart->quantite++;
        
        $cart->save();
        return back();
    }

    // Vérification du panier
    public function checkout(Request $request) {
        if (auth()->user()->role != 'customer')
            abort(403, 'Route reservé au users uniquement.');
            
        $data = $this->validate($request, [
            'type' => ['required'], // type commande (diner / autre chose)
            'dateTime' => ['required', 'after_or_equal:today'], // date de livraison
        ]);

        $subtotal = 0;
        $cartItems = auth()->user()->cartItems->where('order_id', null);
        foreach($cartItems as $item) {
            $subtotal = $subtotal + ($item->menu->prix * $item->quantite);
        }

        $total = $subtotal;
        $discountID = -1;

        // Vérification du code de remise
        if ($request->codeRemise != "" and $request->codeRemise != null) {
            $discountCode = strtoupper($request->codeRemise);
            $usableDiscountCode = Discount::where("codeRemise", $discountCode)->first();

            // si le code de remise existe
            if ($usableDiscountCode) {
                // si ce n'est pas utilisé
                if (($usableDiscountCode->dateDebut <= Carbon::today()) and (($usableDiscountCode->dateFin >= Carbon::today()))) {
                    // vérification intervalle de montant(min, max)
                    if ($usableDiscountCode->soldeMin > $subtotal) {
                        return redirect()
                            ->route('cart')
                            ->with('error', "Vous devez dépenser au moins ".$usableDiscountCode->soldeMin." fcfa pour utiliser ce code de réduction.");
                    }

                    // Si tous les conditions sont respeté, le code peut être utilisé
                    $discountAmount = $subtotal * $usableDiscountCode->pourcentage/100;
                    if ($discountAmount > $usableDiscountCode->soldeMax) {
                        $discountAmount = $usableDiscountCode->soldeMax;
                    }
                    $total = $subtotal - $discountAmount;
                    $discountID = $usableDiscountCode->id;
                    
                } else {
                    return redirect()
                        ->route('cart')
                        ->with('error', "Code non utilisé pour le moment.");
                }
            } else {
                return redirect()
                    ->route('cart')
                    ->with('error', "ce code de remise n'existe pas.");
            }
        }

        // Ajout du taxe au montant total
        $total = $this->currencyFormat($total * 1.06);

        // Création de la commande
        $order = auth()->user()->orders()->create($data);
        
        // Argent total pour le moment
        return redirect()->route('processTransaction', ['transactionAmount' => $total, 'orderId' => $order->id, 'discountID' => $discountID]); 
    }
}
