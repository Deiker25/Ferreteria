<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Librerias
use Illuminate\Support\Facades\Auth;
use Iluminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Credenciales inválidas'
        ], 401);
    }
    $usuario = Auth::user();
    $token = $usuario->createToken('DispositivoFerreteria')->plainTextToken;
    return response()->json([
        'status' => 'success',
        'message' => 'Inicio de sesión exitoso',
        'token' => $token,
        'usuario' => [
            'id' => $usuario->id,
            'name' => $usuario->name,
            'email' => $usuario->email
        ]
    ], 200);
    }
}
