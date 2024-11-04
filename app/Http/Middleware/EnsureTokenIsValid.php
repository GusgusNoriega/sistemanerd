<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    public function handle($request, Closure $next)
    {
        // Obtener el token del encabezado de autorización
        $token = $request->header('Authorization');

        if (!$token) {
            // Retorna un error 401 si no hay token
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        // Limpiar el prefijo "Bearer " del token
        $token = str_replace('Bearer ', '', $token);

        // Verificar si el token es válido y no está revocado
        $isValid = Token::where('id', $token)->where('revoked', false)->exists();

        if (!$isValid) {
            // Retorna un error 401 si el token es inválido
            return response()->json(['error' => 'Token inválido o revocado'], 401);
        }

        return $next($request);
    }
}
