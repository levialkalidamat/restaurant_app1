<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    // Page de commande régulière du client
    public function index() { 
        $activeOrder = auth()->user()->orders()->where('completed', 0)->orderBy('dateTime', 'desc')->first();
        $allOrders = auth()->user()->orders()->orderBy('dateTime', 'desc')->paginate(8);
        return view('pages.commandes.order', compact('activeOrder', 'allOrders'));
    }

    // Page de commande spécifique au client
    public function show(Order $order) { 
        $activeOrder = $order;
        $allOrders = auth()->user()->orders()->orderBy('dateTime', 'desc')->paginate(8);
        return view('pages.commandes.order', compact('activeOrder', 'allOrders'));
    }

    //Page de commande de la cuisine ou de l'administrateur
    public function kitchenOrder() {
        if (auth()->user()->role == 'customer')
            abort(403, 'Route reservé au personnel du restaurant');

        $activeOrders = Order::where('completed', 0)->orderBy('dateTime', 'desc')->paginate(8);
        $firstOrder = $activeOrders->first();
        return view('pages.commandes.kitchenOrder', compact('firstOrder', 'activeOrders'));
    }

    
    //Page de commande spécifique de la cuisine ou de l'administrateur
    public function specificKitchenOrder(Order $order) { 
        if (auth()->user()->role == 'customer')
            abort(403, 'Route reservé au personnel du restaurant');

        $activeOrders = Order::where('completed', 0)->orderBy('dateTime', 'desc')->paginate(8);
        $firstOrder = $order;
        return view('pages.commandes.kitchenOrder', compact('firstOrder', 'activeOrders'));
    }

    //État de la commande de mise à jour de la cuisine ou de l'administrateur
    public function orderStatusUpdate(CartItem $orderItem) {
        if (auth()->user()->role == 'customer')
            abort(403, 'Route reservé au personnel du restaurant');

        $orderItem->status = $orderItem->status ? false : true;
        $orderItem->save();

        $cartItems = CartItem::where('order_id', $orderItem->order_id)->paginate(8);
        foreach ($cartItems as $item) {
            if (!$item->status)
                return redirect()->route('kitchenOrder');
        }
        $orderItem->order->completed = true;
        $orderItem->push();
        return redirect()->route('kitchenOrder');
    }

    //Voire toutes les commandes précédentes
    public function previousOrder() {
        if (auth()->user()->role == 'customer')
            abort(403, 'Route reservé au personnel du restaurant');

        
        $previousOrders = Order::where('completed', 1)->orderBy('dateTime', 'desc')->paginate(8);
        return view('pages.commandes.previousOrder', compact('previousOrders'));
    }
}
