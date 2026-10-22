<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Exceptions\BusinessException;
use App\Support\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    // 1. DAFTARKAN ROUTING (Ini yang tadi hilang)
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(function () {
                    require base_path('routes/api.php');
                });
        },
    )
    // 2. MIDDLEWARE
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn(Request $request) => $request->is('api/*') ? null : '/login');
    })
    // 3. ERROR HANDLER
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // ── 422: ValidationException ──────────────────
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::validation(
                    $e->errors(),
                    $e->getMessage() ?: 'Data yang dikirim tidak valid.',
                );
            }
        });

        // ── 401: AuthenticationException ──────────────
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::unauthenticated();
            }
        });

        // ── 403: AuthorizationException / AccessDenied ─
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::forbidden($e->getMessage() ?: 'Anda tidak memiliki akses.');
            }
        });
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::forbidden($e->getMessage() ?: 'Anda tidak memiliki akses.');
            }
        });

        // ── 404: ModelNotFoundException ──────────────
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                $model = class_basename($e->getModel());
                return ApiResponse::notFound("Data {$model} tidak ditemukan.");
            }
        });

        // ── 404: NotFoundHttpException (route tidak ada) ─
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::notFound('Endpoint tidak ditemukan.');
            }
        });

        // ── 405: MethodNotAllowed ─────────────────────
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    'Metode HTTP tidak diizinkan untuk endpoint ini.',
                    'METHOD_NOT_ALLOWED',
                    405,
                );
            }
        });

        // ── 429: ThrottleRequests ─────────────────────
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*')) {
                $retryAfter = $e->getHeaders()['Retry-After'] ?? null;
                $extra = $retryAfter ? ['retry_after' => (int) $retryAfter] : null;
                return ApiResponse::error(
                    'Terlalu banyak permintaan. Coba lagi nanti.',
                    'TOO_MANY_REQUESTS',
                    429,
                    $extra,
                );
            }
        });

        // ── BusinessException kustom ──────────────────
        $exceptions->render(function (BusinessException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    $e->getMessage(),
                    $e->getCodeName(),
                    $e->getStatusCode(),
                    $e->getDetails(),
                );
            }
        });

        // ── 400: HttpException generic ─────────────────
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    $e->getMessage() ?: 'Permintaan tidak dapat diproses.',
                    'HTTP_ERROR',
                    $e->getStatusCode(),
                );
            }
        });

        // ── 500: QueryException (DB) ──────────────────
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) {
                logger()->error('QueryException', [
                    'message' => $e->getMessage(),
                    'sql'     => $e->getSql(),
                    'bindings' => $e->getBindings(),
                    'url'     => $request->fullUrl(),
                ]);

                $details = config('app.debug') ? ['exception' => $e->getMessage()] : null;

                return ApiResponse::error(
                    'Terjadi kesalahan pada server.',
                    'DATABASE_ERROR',
                    500,
                    $details,
                );
            }
        });

        // ── 500: fallback semua Throwable lain ─────────
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                logger()->error('Unhandled exception', [
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                    'trace'   => $e->getTraceAsString(),
                ]);

                $details = config('app.debug')
                    ? [
                        'exception' => get_class($e),
                        'message'   => $e->getMessage(),
                        'file'      => $e->getFile() . ':' . $e->getLine(),
                    ]
                    : null;

                return ApiResponse::error(
                    'Terjadi kesalahan pada server.',
                    'SERVER_ERROR',
                    500,
                    $details,
                );
            }
        });
    })
    ->create();
