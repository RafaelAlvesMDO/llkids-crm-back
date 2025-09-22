<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $registrationToken;

    public function __construct()
    {
        $this->registrationToken = env('REGISTRATION_TOKEN', 'defaulttoken');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'registration_token' => 'required|string',
            'phone_number' => 'required|string|max:11',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->registration_token !== $this->registrationToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token de Registro Inválido.'
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'employee',
            'phone_number' => $request->phone_number,
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuário registrado com sucesso!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user->type,
                'phone_number' => $user->phone_number,
                'status' => $user->status
            ]
        ], 201);
    }
}
