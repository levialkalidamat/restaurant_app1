<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'nom',
        'description',
        'prix',
        'image',
        'nombre',
        'allergique',
        'vegetarien',
    ];

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }
}
