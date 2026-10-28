<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterBahasaRequest;
use App\Http\Requests\UpdateMasterBahasaRequest;
use App\Models\MasterBahasa;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

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
        try {
            $bahasa = MasterBahasa::create($request->validated());

            return ApiResponse::success($bahasa, 'Master Bahasa berhasil ditambahkan.', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal menambahkan data: ' . $e->getMessage(), 500);
        }
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
        try {
            $bahasa->update($request->validated());

            return ApiResponse::success($bahasa, 'Master Bahasa berhasil diperbarui.');
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal memperbarui data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menghapus Master Bahasa.
     *
     * DELETE /api/v1/master/bahasa/{id}
     */
    public function destroy(MasterBahasa $bahasa): JsonResponse
    {
        try {
            $bahasa->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return ApiResponse::error(
                    'Master Bahasa tidak dapat dihapus karena masih digunakan oleh data lain (misal: data pegawai).',
                    409
                );
            }
            return ApiResponse::error('Gagal menghapus data: ' . $e->getMessage(), 500);
        }

        return ApiResponse::success(null, 'Master Bahasa berhasil dihapus.');
    }
}
