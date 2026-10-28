<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterUnitRequest;
use App\Http\Requests\UpdateMasterUnitRequest;
use App\Models\MasterUnit;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException; // <-- Tambahkan import ini

class MasterUnitController extends Controller
{
    /**
     * GET /api/v1/master/unit
     * Query: search, status, parent_id, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = MasterUnit::query()->with('parent:id,nama,nama_singkat');

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

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        $perPage = (int) $request->get('per_page', 10);

        $data = $query->orderBy('level', 'asc')
            ->orderBy('nama', 'asc')
            ->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Master Unit berhasil diambil.');
    }

    /**
     * POST /api/v1/master/unit
     */
    public function store(StoreMasterUnitRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $data['level'] = $this->resolveLevel($data['parent_id'] ?? null);

            $unit = MasterUnit::create($data);

            return ApiResponse::success(
                $unit->load('parent'),
                'Master Unit berhasil ditambahkan.',
                201
            );
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal menambahkan data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * GET /api/v1/master/unit/{id}
     */
    public function show(MasterUnit $unit): JsonResponse
    {
        return ApiResponse::success(
            $unit->load(['parent', 'children']),
            'Detail Master Unit.'
        );
    }

    /**
     * PUT /api/v1/master/unit/{id}
     */
    public function update(UpdateMasterUnitRequest $request, MasterUnit $unit): JsonResponse
    {
        try {
            $data = $request->validated();

            if (array_key_exists('parent_id', $data)) {
                $newParentId = $data['parent_id'];

                if ($newParentId === $unit->id) {
                    return ApiResponse::error(
                        'Unit tidak boleh menjadi induk dirinya sendiri.',
                        422
                    );
                }

                if ($newParentId !== null) {
                    $newParent = MasterUnit::find($newParentId);

                    if (! $newParent) {
                        return ApiResponse::error('Parent unit tidak ditemukan.', 422);
                    }

                    if ($unit->isAncestorOf($newParent)) {
                        return ApiResponse::error(
                            'Unit tidak boleh memilih turunannya sendiri sebagai induk.',
                            422
                        );
                    }
                }

                $oldLevel        = $unit->level;
                $data['level']   = $this->resolveLevel($newParentId);

                $unit->update($data);

                $delta = $unit->level - $oldLevel;
                if ($delta !== 0) {
                    $this->shiftSubtreeLevel($unit, $delta);
                }
            } else {
                $unit->update($data);
            }

            return ApiResponse::success(
                $unit->load('parent'),
                'Master Unit berhasil diperbarui.'
            );
        } catch (\Exception $e) {
            return ApiResponse::error('Gagal memperbarui data: ' . $e->getMessage(), 500);
        }
    }

    /**
     * DELETE /api/v1/master/unit/{id}
     */
    public function destroy(MasterUnit $unit): JsonResponse
    {
        // 1. Cek relasi secara eksplisit
        if ($unit->children()->exists()) {
            return ApiResponse::error(
                'Master Unit tidak dapat dihapus karena masih memiliki sub-unit.',
                409
            );
        }

        if ($unit->kepegawaian()->exists()) {
            return ApiResponse::error(
                'Master Unit tidak dapat dihapus karena masih digunakan pada data kepegawaian.',
                409
            );
        }

        if ($unit->jabatan_struktural()->exists()) {
            return ApiResponse::error(
                'Master Unit tidak dapat dihapus karena masih digunakan pada data jabatan struktural.',
                409
            );
        }

        try {
            $unit->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return ApiResponse::error(
                    'Master Unit tidak dapat dihapus karena masih digunakan oleh data lain.',
                    409
                );
            }
            return ApiResponse::error('Gagal menghapus data: ' . $e->getMessage(), 500);
        }

        return ApiResponse::success(null, 'Master Unit berhasil dihapus.');
    }

    // ==========================================
    // HELPER
    // ==========================================

    /**
     * Level root = 1, anak = parent.level + 1.
     */
    protected function resolveLevel(?string $parentId): int
    {
        if ($parentId === null) {
            return 1;
        }

        $parent = MasterUnit::findOrFail($parentId);

        return $parent->level + 1;
    }

    /**
     * Geser level seluruh descendant sebesar $delta.
     */
    protected function shiftSubtreeLevel(MasterUnit $unit, int $delta): void
    {
        foreach ($unit->children as $child) {
            $child->update(['level' => $child->level + $delta]);
            $this->shiftSubtreeLevel($child, $delta);
        }
    }
}
