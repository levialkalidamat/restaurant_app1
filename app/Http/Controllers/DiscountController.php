<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (auth()->user()->role != 'admin')
            abort(403, 'Route reservé à admin du restaurant.');
        $discounts = Discount::all();
        return view('pages.remises.discount', compact('discounts'));
    }

    public function createDiscount() {
        if (auth()->user()->role != 'admin')
            abort(403, 'Route reservé à admin du restaurant.');
        return view('pages.remises.createDiscount');
    }

    private function validateDiscount(Request $request, $type) {
        if ($type == 'update')
            $discountCode = ['required', 'string', 'max:30'];
        else
            $discountCode = ['required', 'string', 'max:30', 'unique:App\Models\Discount'];

        $data = $this->validate($request, [
            'codeRemise' => $discountCode,
            'pourcentage' => ['required', 'integer', 'min:1', 'max:100'],
            'soldeMin' => ['required', 'integer', 'min:0', 'max:99999'],
            'soldeMax' => ['required', 'integer', 'min:1' ,'max:99999'],
            'dateDebut' => ['required', 'after_or_equal:today'],
            'dateFin' => ['required', 'after:dateDebut'],
            'description' => ['max:1000'],
        ]);
        return $data;
    }

    public function store(Request $request) {
        if (auth()->user()->role != 'admin')
            abort(403, 'Route reservé à admin du restaurant..');
        
        $data = $this->validateDiscount($request, '');
        $discount = Discount::create(array_merge(
            $data, ['codeRemise' => strtoupper($data['codeRemise'])]
        ));

        return redirect()->route('discount')->with('success', 
                "Code remise '{$discount->codeRemise}' crée avec succès.");
    }

    public function specificDiscount(Discount $discount) {
        if (auth()->user()->role != 'admin')
            abort(403, 'Route réservé au admin.');
        
        
        return view('pages.remises.editDiscount', compact('discount'));
    }

    public function update(Request $request, Discount $discount) {
        $data = $this->validateDiscount($request, 'update');
        $discount->update(array_merge(
            $data, ['codeRemise' => strtoupper($data['codeRemise'])]
        ));
        
        return redirect()->route('discount')->with('success', 
                "Code remise '{$discount->discountCode}' mis à jour avec succès.");
    }

    public function destroy(Discount $discount) {
        $discountCode = $discount->discountCode;
        $discount->delete();
        return redirect()->route('discount')->with('success', 
                "Code remise '{$discountCode}' supprimé avec succès.");
    }
}
