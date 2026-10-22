<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterAgamaRequest;
use App\Http\Requests\UpdateMasterAgamaRequest;
use App\Models\MasterAgama;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterAgamaController extends Controller
{
    /**
     * Menampilkan daftar Master Agama.
     * Bisa dengan pagination & pencarian.
     *
     * GET /api/v1/master/agama
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterAgama::query();

        if ($request->filled('search')) {
            $query->where('nama_agama', 'like', '%' . $request->search . '%');
        }

        // Pagination (default 10 per halaman)
        $perPage = $request->get('per_page', 10);
        $agamas = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::paginated($agamas, 'Daftar Master Agama berhasil diambil.');
    }

    /**
     * Menyimpan Master Agama baru.
     *
     * POST /api/v1/master/agama
     */
    public function store(StoreMasterAgamaRequest $request): JsonResponse
    {
        $agama = MasterAgama::create($request->validated());

        return ApiResponse::success($agama, 'Master Agama berhasil ditambahkan.', 201);
    }

    /**
     * Menampilkan detail Master Agama.
     *
     * GET /api/v1/master/agama/{id}
     */
    public function show(MasterAgama $agama): JsonResponse
    {
        return ApiResponse::success($agama, 'Detail Master Agama.');
    }

    /**
     * Mengubah Master Agama.
     *
     * PUT /api/v1/master/agama/{id}
     */
    public function update(UpdateMasterAgamaRequest $request, MasterAgama $agama): JsonResponse
    {
        $agama->update($request->validated());

        return ApiResponse::success($agama, 'Master Agama berhasil diperbarui.');
    }

    /**
     * Menghapus Master Agama.
     *
     * DELETE /api/v1/master/agama/{id}
     */
    public function destroy(MasterAgama $agama): JsonResponse
    {
        $agama->delete();

        return ApiResponse::success(null, 'Master Agama berhasil dihapus.');
    }
}
