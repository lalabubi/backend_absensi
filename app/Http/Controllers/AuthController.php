<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function Register(Request $request) {
        $validasi = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json(['message' => 'Inputan error', 'errors' => $validasi->errors()]);
        }

        // Hash password before saving
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash password
            'name' => $request->name,
            'siswa_id' => $request->siswa_id,
            'guru_id' => $request->guru_id,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Berhasil membuat akun baru',
            'data' => $user,
            'token' => $token
        ], 200);
    }

    public function Logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout']);
    }

    public function Login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }
}
