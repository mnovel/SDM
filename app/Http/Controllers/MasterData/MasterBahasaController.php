<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterBahasaRequest;
use App\Http\Requests\UpdateMasterBahasaRequest;
use App\Models\MasterBahasa;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterBahasaController extends Controller
{
    /**
     * Menampilkan daftar Master Bahasa.
     * Bisa dengan pagination & pencarian.
     *
     * GET /api/v1/master/bahasa
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterBahasa::query();

        if ($request->filled('search')) {
            $query->where('bahasa', 'like', '%' . $request->search . '%');
        }

        // Pagination (default 10 per halaman)
        $perPage = $request->get('per_page', 10);
        $bahasas = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::paginated($bahasas, 'Daftar Master Bahasa berhasil diambil.');
    }

    /**
     * Menyimpan Master Bahasa baru.
     *
     * POST /api/v1/master/bahasa
     */
    public function store(StoreMasterBahasaRequest $request): JsonResponse
    {
        $bahasa = MasterBahasa::create($request->validated());

        return ApiResponse::success($bahasa, 'Master Bahasa berhasil ditambahkan.', 201);
    }

    /**
     * Menampilkan detail Master Bahasa.
     *
     * GET /api/v1/master/bahasa/{id}
     */
    public function show(MasterBahasa $bahasa): JsonResponse
    {
        return ApiResponse::success($bahasa, 'Detail Master Bahasa.');
    }

    /**
     * Mengubah Master Bahasa.
     *
     * PUT /api/v1/master/bahasa/{id}
     */
    public function update(UpdateMasterBahasaRequest $request, MasterBahasa $bahasa): JsonResponse
    {
        $bahasa->update($request->validated());

        return ApiResponse::success($bahasa, 'Master Bahasa berhasil diperbarui.');
    }

    /**
     * Menghapus Master Bahasa.
     *
     * DELETE /api/v1/master/bahasa/{id}
     */
    public function destroy(MasterBahasa $bahasa): JsonResponse
    {
        $bahasa->delete();

        return ApiResponse::success(null, 'Master Bahasa berhasil dihapus.');
    }
}
