<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterPendidikanRequest;
use App\Http\Requests\UpdateMasterPendidikanRequest;
use App\Models\MasterPendidikan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MasterPendidikanController extends Controller
{
    /**
     * Menampilkan daftar Master Pendidikan.
     *
     * GET /api/v1/master/pendidikan
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterPendidikan::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

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
        try {
            $pendidikan = MasterPendidikan::create($request->validated());

            return ApiResponse::success($pendidikan, 'Master Pendidikan berhasil ditambahkan.', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal menambahkan data: ' . $e->getMessage(), 500);
        }
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
        try {
            $pendidikan->update($request->validated());

            return ApiResponse::success($pendidikan, 'Master Pendidikan berhasil diperbarui.');
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal memperbarui data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menghapus Master Pendidikan.
     *
     * DELETE /api/v1/master/pendidikan/{id}
     */
    public function destroy(MasterPendidikan $pendidikan): JsonResponse
    {
        if ($pendidikan->pangkat()->exists()) {
            return ApiResponse::error(
                'Master Pendidikan tidak dapat dihapus karena masih digunakan oleh data Master Pangkat.',
                409
            );
        }

        try {
            $pendidikan->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return ApiResponse::error(
                    'Master Pendidikan tidak dapat dihapus karena masih digunakan oleh data lain.',
                    409
                );
            }
            return ApiResponse::error('Gagal menghapus data: ' . $e->getMessage(), 500);
        }

        return ApiResponse::success(null, 'Master Pendidikan berhasil dihapus.');
    }
}
