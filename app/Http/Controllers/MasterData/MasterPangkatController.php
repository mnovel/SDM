<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterPangkatRequest;
use App\Http\Requests\UpdateMasterPangkatRequest;
use App\Models\MasterPangkat;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; // <-- Tambahkan import ini

class MasterPangkatController extends Controller
{
    /**
     * Menampilkan daftar Master Pangkat.
     * Bisa dengan pagination & pencarian.
     *
     * GET /api/v1/master/pangkat
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterPangkat::query()->with('pendidikan');

        if ($request->filled('search')) {
            $query->where('pangkat', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 20);
        $pangkat = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::paginated($pangkat, 'Daftar Master Pangkat berhasil diambil.');
    }

    /**
     * Menyimpan Master Pangkat baru.
     *
     * POST /api/v1/master/pangkat
     */
    public function store(StoreMasterPangkatRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $validated['pendidikan_id'] = $validated['pendidikan'];
            unset($validated['pendidikan']);

            $pangkat = MasterPangkat::create($validated);

            return ApiResponse::success($pangkat, 'Master Pangkat berhasil ditambahkan.', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal menambahkan data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan detail Master Pangkat.
     *
     * GET /api/v1/master/pangkat/{id}
     */
    public function show(MasterPangkat $pangkat): JsonResponse
    {
        return ApiResponse::success($pangkat->load('pendidikan'), 'Detail Master Pangkat.');
    }

    /**
     * Mengubah Master Pangkat.
     *
     * PUT /api/v1/master/pangkat/{id}
     */
    public function update(UpdateMasterPangkatRequest $request, MasterPangkat $pangkat): JsonResponse
    {
        try {
            $validated = $request->validated();

            $validated['pendidikan_id'] = $validated['pendidikan'];
            unset($validated['pendidikan']);

            $pangkat->update($validated);

            return ApiResponse::success($pangkat, 'Master Pangkat berhasil diperbarui.');
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal memperbarui data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menghapus Master Pangkat.
     *
     * DELETE /api/v1/master/pangkat/{id}
     */
    public function destroy(MasterPangkat $pangkat): JsonResponse
    {
        try {
            $pangkat->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return ApiResponse::error(
                    'Master Pangkat tidak dapat dihapus karena masih digunakan oleh data lain (misal: data pegawai).',
                    409
                );
            }
            return ApiResponse::error('Gagal menghapus data: ' . $e->getMessage(), 500);
        }

        return ApiResponse::success(null, 'Master Pangkat berhasil dihapus.');
    }
}
