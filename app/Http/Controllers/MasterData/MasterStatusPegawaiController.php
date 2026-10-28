<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterStatusPegawaiRequest;
use App\Http\Requests\UpdateMasterStatusPegawaiRequest;
use App\Models\MasterStatusPegawai;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterStatusPegawaiController extends Controller
{
    /**
     * GET /api/v1/master/status-pegawai
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterStatusPegawai::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = (int) $request->get('per_page', 10);
        $data = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Master Status Pegawai berhasil diambil.');
    }

    /**
     * POST /api/v1/master/status-pegawai
     */
    public function store(StoreMasterStatusPegawaiRequest $request): JsonResponse
    {
        $status = MasterStatusPegawai::create($request->validated());

        return ApiResponse::success($status, 'Master Status Pegawai berhasil ditambahkan.', 201);
    }

    /**
     * GET /api/v1/master/status-pegawai/{id}
     */
    public function show(MasterStatusPegawai $statusPegawai): JsonResponse
    {
        return ApiResponse::success($statusPegawai, 'Detail Master Status Pegawai.');
    }

    /**
     * PUT /api/v1/master/status-pegawai/{id}
     */
    public function update(UpdateMasterStatusPegawaiRequest $request, MasterStatusPegawai $statusPegawai): JsonResponse
    {
        $statusPegawai->update($request->validated());

        return ApiResponse::success($statusPegawai, 'Master Status Pegawai berhasil diperbarui.');
    }

    /**
     * DELETE /api/v1/master/status-pegawai/{id}
     */
    public function destroy(MasterStatusPegawai $statusPegawai): JsonResponse
    {
        // Cegah hapus jika sudah dipakai di pegawai_kepegawaian
        if ($statusPegawai->kepegawaian()->exists()) {
            return ApiResponse::error(
                'Master Status Pegawai tidak dapat dihapus karena masih digunakan pada data kepegawaian.',
                409
            );
        }

        $statusPegawai->delete();

        return ApiResponse::success(null, 'Master Status Pegawai berhasil dihapus.');
    }
}
