<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterKelurahan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterKelurahanController extends Controller
{
    /**
     * GET /api/v1/master/kelurahan
     * Query: search, district_code, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterKelurahan::query();

        if ($request->filled('district_code')) {
            $query->where('district_code', $request->district_code);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $perPage = (int) $request->get('per_page', 20);
        $data = $query->orderBy('name', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Kelurahan berhasil diambil.');
    }

    /**
     * GET /api/v1/master/kelurahan/{id}
     */
    public function show(MasterKelurahan $kelurahan): JsonResponse
    {
        return ApiResponse::success($kelurahan->load('kecamatan.kota.provinsi'), 'Detail Kelurahan.');
    }
}
