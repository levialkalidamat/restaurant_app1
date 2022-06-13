<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'codeRemise', 'pourcentage', 'soldeMin', 'soldeMax',
        'dateDebut', 'dateFin', 'description',
    ];

    // le code de remise peut être utilisée dans de nombreuses transactions
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
