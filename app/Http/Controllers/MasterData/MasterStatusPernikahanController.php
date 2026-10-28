<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterStatusPernikahanRequest;
use App\Http\Requests\UpdateMasterStatusPernikahanRequest;
use App\Models\MasterStatusPernikahan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterStatusPernikahanController extends Controller
{
    /**
     * GET /api/v1/master/status-pernikahan
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterStatusPernikahan::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = (int) $request->get('per_page', 10);
        $data = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Master Status Pernikahan berhasil diambil.');
    }

    /**
     * POST /api/v1/master/status-pernikahan
     */
    public function store(StoreMasterStatusPernikahanRequest $request): JsonResponse
    {
        $status = MasterStatusPernikahan::create($request->validated());

        return ApiResponse::success($status, 'Master Status Pernikahan berhasil ditambahkan.', 201);
    }

    /**
     * GET /api/v1/master/status-pernikahan/{id}
     */
    public function show(MasterStatusPernikahan $statusPernikahan): JsonResponse
    {
        return ApiResponse::success($statusPernikahan, 'Detail Master Status Pernikahan.');
    }

    /**
     * PUT /api/v1/master/status-pernikahan/{id}
     */
    public function update(UpdateMasterStatusPernikahanRequest $request, MasterStatusPernikahan $statusPernikahan): JsonResponse
    {
        $statusPernikahan->update($request->validated());

        return ApiResponse::success($statusPernikahan, 'Master Status Pernikahan berhasil diperbarui.');
    }

    /**
     * DELETE /api/v1/master/status-pernikahan/{id}
     */
    public function destroy(MasterStatusPernikahan $statusPernikahan): JsonResponse
    {
        // FK restrictOnDelete() di pegawai akan menolak; tangkap agar response JSON rapi
        try {
            $statusPernikahan->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return ApiResponse::error(
                    'Master Status Pernikahan tidak dapat dihapus karena masih digunakan oleh data pegawai.',
                    409
                );
            }
            throw $e;
        }

        return ApiResponse::success(null, 'Master Status Pernikahan berhasil dihapus.');
    }
}
