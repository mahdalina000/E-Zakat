<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    /**
     * Terbitkan Personal Access Token (login API).
     */
    public function token(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
            ]);
        }

        // Tolak akun yang dinonaktifkan (is_active = false)
        if ($user->is_active === false) {
            throw ValidationException::withMessages([
                'email' => ['Akun Anda telah dinonaktifkan.'],
            ]);
        }

        $token = $user->createToken($request->device_name ?? 'api-client');

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken,
                'user' => $user->only(['id', 'name', 'email', 'role']),
            ],
        ]);
    }

    /**
     * Cabut token yang sedang dipakai (logout API).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil keluar.',
        ]);
    }

    /**
     * Data user terautentikasi (contoh endpoint terlindungi).
     */
    public function user(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
