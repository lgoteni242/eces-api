<?php

namespace App\Http\Controllers\Groupe8;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:user,admin', // Seuls les admins existants peuvent créer d'autres admins
        ]);

        // Par défaut, les nouveaux utilisateurs sont des 'user'
        // Seuls les admins peuvent créer d'autres admins (vérification à faire côté frontend ou via middleware)
        $role = $request->input('role', 'user');
        
        // Si l'utilisateur essaie de créer un admin, vérifier qu'il est lui-même admin
        if ($role === 'admin' && (!$request->user() || $request->user()->groupe8_role !== 'admin')) {
            $role = 'user'; // Forcer le rôle à 'user' si pas autorisé
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'groupe8_role' => $role,
        ]);

        $token = $user->createToken('groupe8-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->groupe8_role,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants fournis sont incorrects.'],
            ]);
        }

        $token = $user->createToken('groupe8-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->groupe8_role,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}

