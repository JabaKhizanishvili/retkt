<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index(){
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'phpVersion' => PHP_VERSION,
    ]);
    }

    public function about(){
    return Inertia::render('About');
    }

    public function events(){
    return Inertia::render('Events');
    }
    public function contact(){
    return Inertia::render('Contact');
    }

    public function lang(Request $request){
        $request->validate([
            'lang' => ['required', 'string', 'max:2']
        ]);

        session(['locale' => $request->lang]);

        return redirect()->back();

    }


}
