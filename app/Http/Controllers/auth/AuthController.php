<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            return redirect()->intended('/home');
        }

        // Autenticación fallida
        return back()->withInput()->withErrors(['error' => 'Credenciales incorrectas']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function register(Request $request)
    {
        
        // Validate the request
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'cedula' => 'required|integer|min:1000000|max:99999999', // Adjusted for 7-8 digits
            'email' => 'required|string|email|max:255|unique:users',
            'sector' => 'nullable|string|max:255',
            'calle' => 'nullable|string|max:255',
            'casa' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed', // Ensures password confirmation
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'dni' => $request->cedula,
            'email' => $request->email,
            'sector' => $request->sector,
            'calle' => $request->calle,
            'casa' => $request->casa,
            'password' => Hash::make($request->password), // Hash the password
            'status' => 'Activo', // Set the status
        ]);

        // Assign the "cliente" role
        $user->assignRole('cliente');

        // Log in the user
        Auth::login($user);

        // Redirect to intended page after successful registration
        return redirect()->intended('/home');
    }
}
