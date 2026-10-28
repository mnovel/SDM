<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterAgamaRequest;
use App\Http\Requests\UpdateMasterAgamaRequest;
use App\Models\MasterAgama;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

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
        try {

            $agama = MasterAgama::create($request->validated());
            return ApiResponse::success($agama, 'Master Agama berhasil ditambahkan.', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal menambahkan data: ' . $e->getMessage(), 500);
        }
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
        try {
            $agama->update($request->validated());

            return ApiResponse::success($agama, 'Master Agama berhasil diperbarui.');
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal memperbarui data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menghapus Master Agama.
     *
     * DELETE /api/v1/master/agama/{id}
     */
    public function destroy(MasterAgama $agama): JsonResponse
    {
        try {
            $agama->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return ApiResponse::error(
                    'Master Agama tidak dapat dihapus karena masih digunakan oleh data lain (misal: data pegawai).',
                    409
                );
            }
            return ApiResponse::error('Gagal menghapus data: ' . $e->getMessage(), 500);
        }

        return ApiResponse::success(null, 'Master Agama berhasil dihapus.');
    }
}
