<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterProvinsi;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterProvinsiController extends Controller
{
    /**
     * GET /api/v1/master/provinsi
     * Query: search, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterProvinsi::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $perPage = (int) $request->get('per_page', 34);
        $data = $query->orderBy('name', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Provinsi berhasil diambil.');
    }

    /**
     * GET /api/v1/master/provinsi/{id}
     */
    public function show(MasterProvinsi $provinsi): JsonResponse
    {
        return ApiResponse::success($provinsi, 'Detail Provinsi.');
    }

    /**
     * GET /api/v1/master/provinsi/{id}/kota
     */
    public function kota(MasterProvinsi $provinsi): JsonResponse
    {
        $kota = $provinsi->kota()->orderBy('name', 'asc')->get();

        return ApiResponse::success($kota, 'Daftar Kota/Kabupaten dari provinsi ini.');
    }
}
