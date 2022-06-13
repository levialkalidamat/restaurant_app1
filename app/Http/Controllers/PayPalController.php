<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use App\Models\Discount;

class PayPalController extends Controller
{

    // Tous le monde doit être authentifié pour accèder à cette route
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Verification du panier, transaction en cours
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request, float $transactionAmount, int $orderId, int $discountID)
    {

        if ($transactionAmount < 0)
        {
            // Supprimer la commande crée en cas d'echec de transaction
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()->route('cart')->with('error', 'Le montant de la transaction doit être supérieur à 0 fcfa.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction', [$transactionAmount, $orderId, $discountID]),
                "cancel_url" => route('cancelTransaction', $orderId),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $transactionAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirection si transaction accepté
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            // Suppression commande si transaction échouée
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()
                ->route('cart')
                ->with('error', 'Quelque chose est mal passé.');

        } else {

            // Suppression commande si transaction échouée.
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()
                ->route('cart')
                ->with('error', $response['message'] ?? 'Quelque chose est mal passé.');
        }
    }

    /**
     * Transaction reussie.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request, float $transactionAmount, int $orderId, int $discountID)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $order = Order::where('id',$orderId)->first();
            
            // Transaction reussi, vidage du panier.
            $carts = auth()->user()->cartItems()->where('order_id', null)->get();
            foreach($carts as $cart) {
                $cart->order()->associate($order);
                $cart->save();
            }

            // Création de l'objet transaction
            $order->transaction()->create(['somme_finale'=>$transactionAmount]);
            if ($discountID != -1) {
                $discount = Discount::where("id", $discountID)->first();
                $order->transaction->discount()->associate($discount);
                $order->transaction->save();
            }

            return redirect()
                ->route('cart')
                ->with('success', 'Transaction complete.');
        } else {

            // Transaction echoué, suppression de la commande.
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()
                ->route('cart')
                ->with('error', 'Quelque chose s\'est mal passée.');
        }
    }

    /**
     * Annuler transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request, int $orderId)
    {

        // Transaction echoué, suppression de la commande.
        $order = Order::where('id',$orderId)->first()->delete();

        return redirect()
            ->route('cart')
            ->with('error', 'Vous avez annuler la transaction.');
    }
}
