<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiRekening;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PegawaiRekeningController extends Controller
{
    /**
     * GET /api/v1/pegawai/{pegawai}/rekening
     */
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->rekening()->orderBy('created_at', 'desc')->get(), 'Daftar Rekening berhasil diambil.');
    }

    /**
     * POST /api/v1/pegawai/{pegawai}/rekening
     */
    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'nama_bank'   => ['required', 'in:BNI,Mandiri,BTN,BRI,Bank Jatim'],
            'no_rekening' => ['required', 'string', 'max:30'],
            'atas_nama'   => ['required', 'string', 'max:100'],
        ]);

        $rekening = $pegawai->rekening()->create($validated);
        return ApiResponse::success($rekening, 'Data Rekening berhasil ditambahkan.', 201);
    }

    /**
     * GET /api/v1/pegawai/{pegawai}/rekening/{rekening}
     */
    public function show(Pegawai $pegawai, PegawaiRekening $rekening): JsonResponse
    {
        if ($rekening->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($rekening, 'Detail Rekening Pegawai.');
    }

    /**
     * PUT /api/v1/pegawai/{pegawai}/rekening/{rekening}
     */
    public function update(Request $request, Pegawai $pegawai, PegawaiRekening $rekening): JsonResponse
    {
        if ($rekening->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'nama_bank'   => ['sometimes', 'required', 'in:BNI,Mandiri,BTN,BRI,Bank Jatim'],
            'no_rekening' => ['sometimes', 'required', 'string', 'max:30'],
            'atas_nama'   => ['sometimes', 'required', 'string', 'max:100'],
        ]);

        $rekening->update($validated);
        return ApiResponse::success($rekening, 'Data Rekening berhasil diperbarui.');
    }

    /**
     * DELETE /api/v1/pegawai/{pegawai}/rekening/{rekening}
     */
    public function destroy(Pegawai $pegawai, PegawaiRekening $rekening): JsonResponse
    {
        if ($rekening->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $rekening->delete();
        return ApiResponse::success(null, 'Data Rekening berhasil dihapus.');
    }
}
