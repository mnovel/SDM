<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterKota;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterKotaController extends Controller
{
    /**
     * GET /api/v1/master/kota
     * Query: search, province_code, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterKota::query();

        if ($request->filled('province_code')) {
            $query->where('province_code', $request->province_code);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $perPage = (int) $request->get('per_page', 20);
        $data = $query->orderBy('name', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Kota/Kabupaten berhasil diambil.');
    }

    /**
     * GET /api/v1/master/kota/{id}
     */
    public function show(MasterKota $kota): JsonResponse
    {
        return ApiResponse::success($kota->load('provinsi'), 'Detail Kota/Kabupaten.');
    }

    /**
     * GET /api/v1/master/kota/{id}/kecamatan
     */
    public function kecamatan(MasterKota $kota): JsonResponse
    {
        $kecamatan = $kota->kecamatan()->orderBy('name', 'asc')->get();

        return ApiResponse::success($kecamatan, 'Daftar Kecamatan dari kota ini.');
    }
}
