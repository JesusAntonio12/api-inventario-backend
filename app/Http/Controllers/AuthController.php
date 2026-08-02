<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $identificador = $request->input('usuario');
        $password = $request->input('contra');

        if (!$identificador || !$password) {
            return response()->json(['success' => false, 'mensaje' => 'Faltan datos.'], 400);
        }

        $user = User::where('usuario', $identificador)->orWhere('correo', $identificador)->first();

        // Validamos si existe el usuario
        if (!$user) {
            return response()->json(['success' => false, 'mensaje' => 'Credenciales incorrectas.'], 401);
        }

        // Validamos la contraseña (híbrido: acepta texto plano o encriptado)
        $es_valida = false;
        if (strpos($user->contra, '$2y$') === 0) {
            $es_valida = password_verify($password, $user->contra);
        } else {
            $es_valida = ($password === $user->contra); 
        }

        if (!$es_valida) {
            return response()->json(['success' => false, 'mensaje' => 'Credenciales incorrectas.'], 401);
        }

        $codigo_mfa = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->codigo_mfa = $codigo_mfa;
        $user->save();

        return response()->json([
            'success' => true,
            'mensaje' => 'Validación exitosa. Ingresa tu código.',
            'datos_usuario' => [
                'id' => $user->id,
                'usuario' => $user->usuario,
                'rol' => $user->rol,
            ],
            'mfa_bypass' => $codigo_mfa 
        ]);
    }
    public function crearPrueba(Request $request)
    {
        $nombre_negocio = $request->input('nombre_negocio');
        $correo = $request->input('correo');

        // Aquí iría tu lógica de base de datos para crear la franquicia o usuario temporal.
        // Por ahora, validamos que lleguen los datos.
        if (!$nombre_negocio || !$correo) {
            return response()->json(['success' => false, 'msg' => 'Por favor llena todos los campos.']);
        }

        // Simulación de creación de cuenta exitosa
        return response()->json([
            'success' => true,
            'msg' => 'Entorno creado con éxito.'
        ]);
    }
}