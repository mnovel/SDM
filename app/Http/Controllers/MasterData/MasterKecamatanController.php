<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterKecamatan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterKecamatanController extends Controller
{
    /**
     * GET /api/v1/master/kecamatan
     * Query: search, city_code, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterKecamatan::query();

        if ($request->filled('city_code')) {
            $query->where('city_code', $request->city_code);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $perPage = (int) $request->get('per_page', 20);
        $data = $query->orderBy('name', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Kecamatan berhasil diambil.');
    }

    /**
     * GET /api/v1/master/kecamatan/{id}
     */
    public function show(MasterKecamatan $kecamatan): JsonResponse
    {
        return ApiResponse::success($kecamatan->load('kota.provinsi'), 'Detail Kecamatan.');
    }

    /**
     * GET /api/v1/master/kecamatan/{id}/kelurahan
     */
    public function kelurahan(MasterKecamatan $kecamatan): JsonResponse
    {
        $kelurahan = $kecamatan->kelurahan()->orderBy('name', 'asc')->get();

        return ApiResponse::success($kelurahan, 'Daftar Kelurahan dari kecamatan ini.');
    }
}
