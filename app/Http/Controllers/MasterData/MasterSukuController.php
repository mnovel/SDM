<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterSukuRequest;
use App\Http\Requests\UpdateMasterSukuRequest;
use App\Models\MasterSuku;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterSukuController extends Controller
{
    /**
     * GET /api/v1/master/suku
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterSuku::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $perPage = (int) $request->get('per_page', 10);
        $data = $query->orderBy('nama', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Master Suku berhasil diambil.');
    }

    /**
     * POST /api/v1/master/suku
     */
    public function store(StoreMasterSukuRequest $request): JsonResponse
    {
        $suku = MasterSuku::create($request->validated());

        return ApiResponse::success($suku, 'Master Suku berhasil ditambahkan.', 201);
    }

    /**
     * GET /api/v1/master/suku/{id}
     */
    public function show(MasterSuku $suku): JsonResponse
    {
        return ApiResponse::success($suku, 'Detail Master Suku.');
    }

    /**
     * PUT /api/v1/master/suku/{id}
     */
    public function update(UpdateMasterSukuRequest $request, MasterSuku $suku): JsonResponse
    {
        $suku->update($request->validated());

        return ApiResponse::success($suku, 'Master Suku berhasil diperbarui.');
    }

    /**
     * DELETE /api/v1/master/suku/{id}
     */
    public function destroy(MasterSuku $suku): JsonResponse
    {
        $suku->delete();

        return ApiResponse::success(null, 'Master Suku berhasil dihapus.');
    }
}
