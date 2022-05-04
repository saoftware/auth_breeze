<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //Retourne la page de connexion pour l'admin
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

    // Retourne la vue de création d'un compte admin
    public function AdminRegister()
    {
        return view('admin.admin_register');
    }

    // Fonction de vérification des infos création de compte
    public function AdminRegisterCreate(Request $request)
    {
        Admin::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login_form')->with('error', 'Admin created successfully');
    }
    
}