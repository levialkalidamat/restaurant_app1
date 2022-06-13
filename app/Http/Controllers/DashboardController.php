<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (auth()->user()->role != 'admin')
            abort(403, 'Route reservé au admin seulement.');

        
        $lastMonthDate = Carbon::now()->subDays(30)->toDateTimeString();
        $today = Carbon::today()->toDateString();
        $oneMonthTransactions = Transaction::where('created_at', '>=', $lastMonthDate)->get();
        
        // Calcul revenue 
        $totalRevenue = $oneMonthTransactions->sum("somme_finale");
        // revenue en 30 jours
        $dailyRevenue = Transaction::select(
            DB::raw('date(created_at) as date'), DB::raw('SUM(somme_finale) as revenue'))
            ->where('created_at', '>=', $lastMonthDate)
            ->groupBy('date')->orderBy('date')->get();
        
        //   Calcul cout estimé  
        $totalCost = 0;
        foreach ($oneMonthTransactions as $transaction) {
            $totalCost += $transaction->order->getTotalCost();
        }
        

        //  calcul du gain
        $grossProfit = $totalRevenue - $totalCost;    

        //   Commandes totales 
        $totalOrders = $oneMonthTransactions->count();
        $dailyOrders = Order::select(
            DB::raw('date(dateTime) as date'), DB::raw('COUNT(*) as orders'))
            ->where('created_at', '>=', $lastMonthDate)
            ->groupBy('date')->orderBy('date')->get();
        

        //   Catégorie de plats   
        $categoricalSales = [0, 0, 0, 0, 0, 0, 0];
        foreach ($oneMonthTransactions as $transaction) {
            $cartItems = $transaction->order->cartItems;

            foreach ($cartItems as $item) {
                $itemType = $item->menu->type;
                $itemPrice = $item->menu->prix;
                $itemQty = $item->quantite;

                switch($itemType) {
                    case "Aperitif":
                        $categoricalSales[0] += $itemPrice * $itemQty;
                    case "Dejeuner":
                        $categoricalSales[1] += $itemPrice * $itemQty;
                    case "Diner":
                        $categoricalSales[2] += $itemPrice * $itemQty;
                    case "Repas":
                        $categoricalSales[3] += $itemPrice * $itemQty;
                    case "Nord":
                        $categoricalSales[4] += $itemPrice * $itemQty;
                    case "Sud":
                        $categoricalSales[5] += $itemPrice * $itemQty;
                    case "Dessert":
                        $categoricalSales[6] += $itemPrice * $itemQty;
                }
            }
        }
        for ($i=0; $i < count($categoricalSales) ; $i++) {
            $categoricalSales[$i] = number_format((float)$categoricalSales[$i], 2, '.', '');
        }
        

        // produit le plus vendu
        $productSales = array();
        foreach ($oneMonthTransactions as $transaction) {
            $cartItems = $transaction->order->cartItems;

            foreach ($cartItems as $item) {
                $itemName = $item->menu->nom;
                $itemQty = $item->quantite;
                if (isset($productSales[$itemName])) {
                    $productSales[$itemName] = $productSales[$itemName] + $itemQty;
                } else {
                    $productSales[$itemName] = $itemQty;
                }
            }
        }
        arsort($productSales);
        $finalProductSales = array();
        foreach ($productSales as $product => $sale_count) {
            $temp = array();
            $temp['x'] = $product;
            $temp['y'] = $sale_count;
            array_push($finalProductSales, $temp);
        }


        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod(new DateTime($lastMonthDate), $interval, new DateTime($today));  
        
        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            if (!$dailyRevenue->contains('date', $date))
                $dailyRevenue->push(array('date' => $date, 'revenue' => 0));
            if (!$dailyOrders->contains('date', $date))
                $dailyOrders->push(array('date' => $date, 'orders' => 0));
        }

        // classement du tableau par date
        $dailyRevenue = $dailyRevenue->toArray();
        $dailyOrders = $dailyOrders->toArray();
        $dates = array_column($dailyRevenue, 'date');
        array_multisort($dates, $dailyRevenue);
        $dates = array_column($dailyOrders, 'date');
        array_multisort($dates, $dailyOrders);
        $dailyRevenue = json_encode($dailyRevenue);
        $dailyOrders = json_encode($dailyOrders);
        $categoricalSales = json_encode($categoricalSales);
        $finalProductSales = json_encode($finalProductSales);

        // calcul heure utilisation code de réduction
        $discountCodeUsed = Transaction::where("order_id", "!=", null)->count();

        // calcul du nombre de client
        $numCustomer = User::where("role", "customer")->count();
        
        $startDate = Carbon::parse($lastMonthDate)->format('Y-m-d');
        return view('dashboard', compact("startDate", "today", "totalRevenue", "dailyRevenue", "totalCost", "grossProfit",
                "totalOrders", "dailyOrders", "discountCodeUsed", "numCustomer", "categoricalSales", "finalProductSales")); 
    }
}
