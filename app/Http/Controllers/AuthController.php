<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Intentar autenticar al usuario
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Revocar todos los tokens anteriores del usuario
        $user->tokens()->delete();


        // Crear un token de acceso personal para el usuario
        $token = $user->createToken('Personal Access Token')->accessToken;

        // Retornar el token de acceso
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

   
}
