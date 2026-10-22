<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login — menerbitkan JWT baru.
     *
     * POST /api/v1/auth/login
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('username', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password salah.'],
            ]);
        }

        /** @var \App\Models\User $user */
        $user = auth('api')->user();

        // Akun nonaktif: batalkan token, tolak akses (→ handler: 403 FORBIDDEN)
        if (! $user->is_active) {
            auth('api')->logout();
            abort(403, 'Akun Anda sedang tidak aktif. Hubungi admin.');
        }

        $user->forceFill(['last_login_at' => now()])->save();

        return ApiResponse::success(
            data: [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
                'user'         => $user,
            ],
            message: 'Login berhasil.',
        );
    }

    /**
     * Data user yang sedang login.
     *
     * GET /api/v1/auth/me
     */
    public function me(): JsonResponse
    {
        return ApiResponse::success(auth('api')->user());
    }

    /**
     * Logout — invalidasi token saat ini.
     *
     * POST /api/v1/auth/logout
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return ApiResponse::success(message: 'Berhasil logout.');
    }

    /**
     * Refresh token — menerbitkan token baru dari token lama.
     *
     * POST /api/v1/auth/refresh
     */
    public function refresh(): JsonResponse
    {
        return ApiResponse::success(
            data: [
                'access_token' => auth('api')->refresh(),
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
                'user'         => auth('api')->user(),
            ],
            message: 'Token berhasil diperbarui.',
        );
    }
}