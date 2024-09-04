<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong.',
            'email' => ':attribute harus berupa email yang valid.',
            'string' => ':attribute harus berupa string.',
            'unique' => ':attribute sudah terdaftar.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'phone' => 'required|string|unique:users|min:12|max:13',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Admin gagal daftar.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $payload = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'role' => 'admin',
        ];

        $user = User::create($payload);

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil daftar.',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong.',
            'email' => ':attribute harus berupa email yang valid.',
            'string' => ':attribute harus berupa string.',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal login.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        try {
            $token = $user->createToken('authToken', ['*'], now()->addMinutes(60))->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil.',
                'data' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function user()
    {
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'message' => 'User data',
            'data' => $user,
        ]);
    }

    public function logout()
    {
        if (auth()->user()->tokens()->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Successful',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Logout Failed',
        ]);
    }
}
