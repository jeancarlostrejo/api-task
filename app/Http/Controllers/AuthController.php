<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User created satisfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credentials incorrects'], 401);
        }

        $user = Auth::user();

        //Esto para que el editor no me marque un undefined method, esto debido a que Auth::user() retorna un Authenticable|null, como puede devolver null entonces no tendría ningun método, por eso la advertencia del editor si no se colocar la condicion
        if ($user instanceof User) {

            $token = $user->createToken('token-example-name')->plainTextToken;
        }

        return response()->json(['user' => $user, "token" => $token]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'User logout satisfully']);
    }
}
