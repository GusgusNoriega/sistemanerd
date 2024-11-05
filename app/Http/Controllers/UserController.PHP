<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de importar el modelo User

class UserController extends Controller
{
    public function getUserData($id)
    {
        // Busca el usuario por ID
        $user = User::find($id);

        // Verifica si el usuario existe
        if ($user) {
            // Retorna los datos del usuario en formato JSON
            return response()->json($user);
        } else {
            // Si el usuario no existe, retorna un error 404
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }
}