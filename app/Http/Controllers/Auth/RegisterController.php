<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return inertia(
            'Auth/Register'
        );
    }

    public function store(Request $request)
    {
        $messages = [
            'email' => 'Podany adres e-mail jest już zajęty.',
            'confirmed' => 'Podane hasła różnią się.',
            'min' => 'Hasło musi składać się przynajmniej z :min znaków.',
        ];

        $user = User::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ], $messages));

        Auth::login($user);
        event(new Registered($user));
        
        return redirect()->route('listing.index')
            ->with('success', 'Stworzono nowe konto i zalogowano');
    }
}
