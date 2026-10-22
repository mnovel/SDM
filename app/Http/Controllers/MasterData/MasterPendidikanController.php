<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterPendidikanRequest;
use App\Http\Requests\UpdateMasterPendidikanRequest;
use App\Models\MasterPendidikan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterPendidikanController extends Controller
{
    /**
     * Menampilkan daftar Master Pendidikan.
     * Bisa dengan pagination & pencarian.
     *
     * GET /api/v1/master/pendidikan
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterPendidikan::query();

        if ($request->filled('search')) {
            $query->where('pendidikan', 'like', '%' . $request->search . '%');
        }

        // Pagination (default 10 per halaman)
        $perPage = $request->get('per_page', 10);
        $pendidikan = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::paginated($pendidikan, 'Daftar Master Pendidikan berhasil diambil.');
    }

    /**
     * Menyimpan Master Pendidikan baru.
     *
     * POST /api/v1/master/pendidikan
     */
    public function store(StoreMasterPendidikanRequest $request): JsonResponse
    {
        $pendidikan = MasterPendidikan::create($request->validated());

        return ApiResponse::success($pendidikan, 'Master Pendidikan berhasil ditambahkan.', 201);
    }

    /**
     * Menampilkan detail Master Pendidikan.
     *
     * GET /api/v1/master/pendidikan/{id}
     */
    public function show(MasterPendidikan $pendidikan): JsonResponse
    {
        return ApiResponse::success($pendidikan, 'Detail Master Pendidikan.');
    }

    /**
     * Mengubah Master Pendidikan.
     *
     * PUT /api/v1/master/pendidikan/{id}
     */
    public function update(UpdateMasterPendidikanRequest $request, MasterPendidikan $pendidikan): JsonResponse
    {
        $pendidikan->update($request->validated());

        return ApiResponse::success($pendidikan, 'Master Pendidikan berhasil diperbarui.');
    }

    /**
     * Menghapus Master Pendidikan.
     *
     * DELETE /api/v1/master/pendidikan/{id}
     */
    public function destroy(MasterPendidikan $pendidikan): JsonResponse
    {
        $pendidikan->delete();

        return ApiResponse::success(null, 'Master Pendidikan berhasil dihapus.');
    }
}
