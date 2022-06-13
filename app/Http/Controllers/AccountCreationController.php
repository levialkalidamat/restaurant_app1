<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AccountCreationController extends Controller
{

    // vérifie que l'utilisateur est authentifié
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Renvoi le formualire de création de compte
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // only admins are allowed to view this page.
        if (auth()->user()->role != 'admin')
            abort(403, 'Route reservé admin.');

        return view('accountCreation'); 
    }

    /**
     * Handle incoming account creation requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // validation des requete.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'string']
        ]);

        // création du user.
        $user = User::create([
            'username' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        // redirection vers la page de création avec message de succès.
        return redirect()->route('accountCreation')->with('success', 'Compte créer avec succès!');
    }
}
