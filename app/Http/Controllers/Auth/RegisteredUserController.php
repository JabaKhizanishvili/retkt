<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        dd($request->post());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if($request->type == 2){
            dd('asd');
           $request->validate([
                'id_front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_number' => 'string|min:11|max:11|unique:'.User::class,
                'phone' => 'required|',
                'id_number' => 'required',
           ]);

        }

        dd('asd');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_address' => $request->id_address,
            'type' => $request->type,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}