<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'phpVersion' => PHP_VERSION,
    ]);
    }
}