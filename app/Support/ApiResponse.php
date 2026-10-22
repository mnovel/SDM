<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiResponse
{
    /**
     * Respons sukses.
     */
    public static function success(
        mixed $data = null,
        string $message = 'OK',
        int $status = 200,
        ?array $meta = null,
    ): JsonResponse {
        $body = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        if ($meta !== null) {
            $body['meta'] = $meta;
        }

        return response()->json($body, $status);
    }

    /**
     * Respons sukses dengan pagination.
     */
    public static function paginated(
        LengthAwarePaginator $paginator,
        string $message = 'OK',
        ?callable $transform = null,
    ): JsonResponse {
        $items = $transform
            ? collect($paginator->items())->map($transform)
            : $paginator->items();

        return self::success(
            data:    $items,
            message: $message,
            meta:    [
                'page'     => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total'    => $paginator->total(),
                'last_page'=> $paginator->lastPage(),
            ],
        );
    }

    /**
     * Respons error.
     */
    public static function error(
        string $message,
        string $code = 'ERROR',
        int $status = 400,
        ?array $details = null,
        ?array $extra = null,
    ): JsonResponse {
        $error = [
            'code' => $code,
        ];

        if ($details !== null) {
            $error['details'] = $details;
        }

        $body = [
            'success' => false,
            'message' => $message,
            'error'   => $error,
        ];

        if ($extra !== null) {
            $body = array_merge($body, $extra);
        }

        return response()->json($body, $status);
    }

    /**
     * Respons validasi (422).
     */
    public static function validation(array $errors, string $message = 'Data yang dikirim tidak valid.'): JsonResponse
    {
        return self::error($message, 'VALIDATION_ERROR', 422, $errors);
    }

    /**
     * Respons tidak terautentikasi (401).
     */
    public static function unauthenticated(string $message = 'Sesi tidak valid. Silakan login kembali.'): JsonResponse
    {
        return self::error($message, 'UNAUTHENTICATED', 401);
    }

    /**
     * Respons terlarang (403).
     */
    public static function forbidden(string $message = 'Anda tidak memiliki akses.'): JsonResponse
    {
        return self::error($message, 'FORBIDDEN', 403);
    }

    /**
     * Respons tidak ditemukan (404).
     */
    public static function notFound(string $message = 'Data tidak ditemukan.'): JsonResponse
    {
        return self::error($message, 'NOT_FOUND', 404);
    }
}