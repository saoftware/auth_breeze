<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    //Retourne la page de connexion pour seller
    public function Index()
    {
        return view('seller.seller_login');
    }

    // Retourne le tableau de bord de seller
    public function Dashboard()
    {
        return view('seller.index');
    }

    // Fonction permettant de vérifier les infos de connexion seller
    public function Login(Request $request)
    {
        $check = $request->all();

        if(Auth::guard('seller')->attempt(['email' => $check['email'], 'password' => $check['password']])){
            return redirect()->route('seller.dashboard')->with('error', 'Seller login successfully');
        }
        else{
            return back()->with('error', 'Email ou mot de passe invalide');
        }
    }

    // Fonction de déconnexion
    public function SellerLogout()
    {
        Auth::guard('seller')->logout();
        return redirect()->route('seller_login_form')->with('error', 'Seller logout successfully');
    }

    // Retourne la vue de création d'un compte admin
    public function SellerRegister()
    {
        return view('seller.seller_register');
    }

    // Fonction de vérification des infos création de compte
    public function SellerRegisterCreate(Request $request)
    {
        Seller::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('seller_login_form')->with('error', 'Seller created successfully');
    }
}