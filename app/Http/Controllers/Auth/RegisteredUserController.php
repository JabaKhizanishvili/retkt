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
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;

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

        $type = $request->type;

        if($type == 2){
           $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'id_front_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_back_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_number' => 'string|min:11|max:11|unique:'.User::class,
                'phone' => 'required|unique:'.User::class,
           ]);
        }else{
            $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_number' => $request->id_address,
            'type' => $type,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        if($type == 2){
            $userId = $user->id;
            $idFrontImageName = Str::random(20) . '.' . $request->file('id_front_img')->getClientOriginalExtension();
            $idBackImageName = Str::random(20) . '.' . $request->file('id_back_img')->getClientOriginalExtension();

            $idFrontImagePath = $request->file('id_front_img')->storeAs("public/images/validation/$userId", $idFrontImageName);
            $idBackImagePath = $request->file('id_back_img')->storeAs("public/images/validation/$userId", $idBackImageName);

            $user->update([
                'id_front_img' => $idFrontImagePath,
                'id_back_img' => $idBackImagePath,
            ]);

        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
}
}