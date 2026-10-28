<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterJabatanRequest;
use App\Http\Requests\UpdateMasterJabatanRequest;
use App\Models\MasterJabatan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class MasterJabatanController extends Controller
{
    /**
     * Helper untuk meratakan (flatten) response JSON.
     */
    private function formatJabatanResponse(MasterJabatan $jabatan): array
    {
        $jabatan->loadMissing('unit_formasi.unit');
        $formasi = $jabatan->unit_formasi->first();
        $data = $jabatan->makeHidden('unit_formasi')->toArray();

        $data['kode_jabatan'] = $formasi ? $formasi->kode_jabatan : null;
        $data['unit']         = $formasi ? $formasi->unit : null;

        return $data;
    }

    /**
     * GET /api/v1/master/jabatan
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterJabatan::with('unit_formasi.unit');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nama_singkat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('unit_id')) {
            $query->whereHas('unit_formasi', function ($q) use ($request) {
                $q->where('unit_id', $request->unit_id);
            });
        }

        $perPage = (int) $request->get('per_page', 10);
        $data = $query->orderBy('nama', 'asc')->paginate($perPage);

        $data->getCollection()->transform(function ($item) {
            return $this->formatJabatanResponse($item);
        });

        return ApiResponse::paginated($data, 'Daftar Master Jabatan berhasil diambil.');
    }

    /**
     * POST /api/v1/master/jabatan
     */
    public function store(StoreMasterJabatanRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $jabatan = MasterJabatan::create([
                'nama'         => $validated['nama'],
                'nama_singkat' => $validated['nama_singkat'],
                'status'       => $validated['status'],
            ]);

            $jabatan->unit_formasi()->create([
                'unit_id'      => $validated['unit_id'],
                'kode_jabatan' => $validated['kode_jabatan'] ?? null,
                'is_aktif'     => true,
            ]);

            DB::commit();

            return ApiResponse::success(
                $this->formatJabatanResponse($jabatan),
                'Master Jabatan beserta Unit berhasil ditambahkan.',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Gagal menambahkan data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * GET /api/v1/master/jabatan/{id}
     */
    public function show(MasterJabatan $jabatan): JsonResponse
    {
        return ApiResponse::success(
            $this->formatJabatanResponse($jabatan),
            'Detail Master Jabatan.'
        );
    }

    /**
     * PUT /api/v1/master/jabatan/{id}
     */
    public function update(UpdateMasterJabatanRequest $request, MasterJabatan $jabatan): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $jabatan->update([
                'nama'         => $validated['nama'] ?? $jabatan->nama,
                'nama_singkat' => $validated['nama_singkat'] ?? $jabatan->nama_singkat,
                'status'       => $validated['status'] ?? $jabatan->status,
            ]);

            if (isset($validated['unit_id'])) {
                $jabatan->unit_formasi()->updateOrCreate(
                    ['jabatan_id' => $jabatan->id],
                    [
                        'unit_id'      => $validated['unit_id'],
                        'kode_jabatan' => $validated['kode_jabatan'] ?? null,
                    ]
                );
            }

            DB::commit();

            return ApiResponse::success(
                $this->formatJabatanResponse($jabatan),
                'Master Jabatan beserta Unit berhasil diperbarui.'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Gagal memperbarui data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * DELETE /api/v1/master/jabatan/{id}
     */
    public function destroy(MasterJabatan $jabatan): JsonResponse
    {
        if ($jabatan->kepegawaian()->exists() || $jabatan->jabatan_struktural()->exists()) {
            return ApiResponse::error(
                'Master Jabatan tidak dapat dihapus karena masih digunakan pada data kepegawaian / jabatan struktural.',
                409
            );
        }

        DB::beginTransaction();
        try {
            $jabatan->unit_formasi()->delete();

            $jabatan->delete();

            DB::commit();

            return ApiResponse::success(null, 'Master Jabatan berhasil dihapus.');
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() === '23000') {
                return ApiResponse::error(
                    'Master Jabatan tidak dapat dihapus karena masih digunakan oleh data lain.',
                    409
                );
            }

            return ApiResponse::error('Gagal menghapus data: ' . $e->getMessage(), 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Terjadi kesalahan sistem: ' . $e->getMessage(), 500);
        }
    }
}
