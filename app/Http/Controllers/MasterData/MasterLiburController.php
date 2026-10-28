<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterLiburRequest;
use App\Http\Requests\UpdateMasterLiburRequest;
use App\Models\MasterLibur;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterLiburController extends Controller
{
    /**
     * Menampilkan daftar Master Libur.
     * Bisa dengan pagination & pencarian.
     *
     * GET /api/v1/master/libur
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterLibur::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis_libur')) {
            $query->where('jenis_libur', $request->jenis_libur);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 10);
        $libur = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::paginated($libur, 'Daftar Master Libur berhasil diambil.');
    }

    /**
     * Menyimpan Master Libur baru.
     *
     * POST /api/v1/master/libur
     */
    public function store(StoreMasterLiburRequest $request): JsonResponse
    {
        $libur = MasterLibur::create($request->validated());

        return ApiResponse::success($libur, 'Master Libur berhasil ditambahkan.', 201);
    }

    /**
     * Menampilkan detail Master Libur.
     *
     * GET /api/v1/master/libur/{id}
     */
    public function show(MasterLibur $libur): JsonResponse
    {
        return ApiResponse::success($libur, 'Detail Master Libur.');
    }

    /**
     * Mengubah Master Libur.
     *
     * PUT /api/v1/master/libur/{id}
     */
    public function update(UpdateMasterLiburRequest $request, MasterLibur $libur): JsonResponse
    {
        $libur->update($request->validated());

        return ApiResponse::success($libur, 'Master Libur berhasil diperbarui.');
    }

    /**
     * Menghapus Master Libur.
     *
     * DELETE /api/v1/master/libur/{id}
     */
    public function destroy(MasterLibur $libur): JsonResponse
    {
        $libur->delete();

        return ApiResponse::success(null, 'Master Libur berhasil dihapus.');
    }
}
