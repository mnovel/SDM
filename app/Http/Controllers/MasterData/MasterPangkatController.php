<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterPangkatRequest;
use App\Http\Requests\UpdateMasterPangkatRequest;
use App\Models\MasterPangkat;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        // Pagination (default 20 per halaman)
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
        $validated = $request->validated();
        $validated['pendidikan_id'] = $validated['pendidikan'];
        unset($validated['pendidikan']);

        $pangkat = MasterPangkat::create($validated);

        return ApiResponse::success($pangkat, 'Master Pangkat berhasil ditambahkan.', 201);
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
        $pangkat->update($request->validated());

        return ApiResponse::success($pangkat, 'Master Pangkat berhasil diperbarui.');
    }

    /**
     * Menghapus Master Pangkat.
     *
     * DELETE /api/v1/master/pangkat/{id}
     */
    public function destroy(MasterPangkat $pangkat): JsonResponse
    {
        $pangkat->delete();

        return ApiResponse::success(null, 'Master Pangkat berhasil dihapus.');
    }
}
