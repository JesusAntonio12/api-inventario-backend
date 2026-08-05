<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'usuario'  => 'required',
            'password' => 'required',
        ]);

        // Busca por usuario O por correo
        $user = User::where('usuario', $request->usuario)
                    ->orWhere('correo', $request->usuario)
                    ->first();

        if (! $user || ! Hash::check($request->password, $user->contra)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $token = $user->createToken('web-token')->plainTextToken;

        return response()->json([
            'message' => 'Login correcto',
            'token'   => $token,
            'user'    => [
                'id'        => $user->id,
                'usuario'   => $user->usuario,
                'rol'       => $user->rol,
                'id_tienda' => $user->id_tienda,
            ],
        ]);
    }

    public function dashboard(Request $request)
    {
        return response()->json([
            'message' => 'Bienvenido al dashboard',
            'user'    => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    }
}