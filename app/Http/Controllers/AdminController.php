<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    //Retourne la page de connexion pou l'admin
    public function Index()
    {
        return view('admin.admin_login');
    }
    
    // Retourne le tableau de bord de l'admin
    public function Dashboard()
    {
        return view('admin.index');
    }

    // Fonction permettant de vérifier les infos de connexion d'un admin
    public function Login(Request $request)
    {
        $check = $request->all();

        if(Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])){
            return redirect()->route('admin.dashboard')->with('error', 'Admin login successfully');
        }
        else{
            return back()->with('error', 'Email ou mot de passe invalide');
        }
    }

    // Fonction de déconnexion
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('error', 'Admin logout successfully');
    }
    
}