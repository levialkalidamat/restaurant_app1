<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'dateTime',
        'type',
    ];

    public function getOrderDate() {
        $dateTime = $this->dateTime;
        return substr($dateTime, 0, 10);
    }
    
    public function getOrderTime() {
        $dateTime = $this->dateTime;
        return substr($dateTime, 11, 16);
    }

    public function getSubtotal() {
        $totalPrice = 0;
        foreach($this->cartItems as $item) 
            $totalPrice += $item->menu->prix * $item->quantite;
        return $this->currencyFormat($totalPrice);
    }

    public function getDiscount($subtotal) {
        
        if ($this->transaction != null && $this->transaction->discount!= null) {
            $discount = $this->transaction->discount->pourcentage;
            if (($subtotal * $discount/100) < ($this->transaction->discount->soldeMax)) {
                return $this->currencyFormat($subtotal * $discount/100);
            } else {
                return $this->transaction->discount->soldeMax;
            }
        } else {
            return 0;
        }
    }

    public function getTax($subtotal, $discount) {
        return $this->currencyFormat(($subtotal - $discount) * 0.06);
    }

    public function getTotal($subtotal, $discount, $tax) {
        return $this->currencyFormat($subtotal - $discount + $tax);
    }

    public function getTotalFromScratch() {
        $subtotal = $this->getSubtotal();
        $discount = $this->getDiscount($subtotal);
        $tax = $this->getTax($subtotal, $discount);
        return $this->currencyFormat($subtotal - $discount + $tax);
    }

    public function getTotalCost() {
        $totalCost = 0;
        foreach ($this->cartItems as $item) {
            $totalCost += floatval($item->menu->coutEstime) * floatval($item->quantite);
        }
        return $this->currencyFormat($totalCost);
    }

    public function currencyFormat($number) {
        return number_format((float)$number, 2, '.', '');
    }
  
    // les différentes relations
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }
}
