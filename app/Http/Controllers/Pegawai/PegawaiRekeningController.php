<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PegawaiRekeningController extends Controller
{
    public function show(Pegawai $pegawai): JsonResponse
    {
        if (! $pegawai->rekening) return ApiResponse::error('Data Rekening tidak ditemukan.', 404);
        return ApiResponse::success($pegawai->rekening, 'Detail Rekening Pegawai.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        if ($pegawai->rekening()->exists()) return ApiResponse::error('Rekening sudah ada, gunakan PUT untuk update.', 409);

        $validated = $request->validate([
            'nama_bank'   => ['required', 'in:BNI,Mandiri,BTN,BRI,Bank Jatim'],
            'no_rekening' => ['required', 'string', 'max:30'],
            'atas_nama'   => ['required', 'string', 'max:100'],
        ]);

        $rekening = $pegawai->rekening()->create($validated);
        return ApiResponse::success($rekening, 'Data Rekening berhasil ditambahkan.', 201);
    }

    public function update(Request $request, Pegawai $pegawai): JsonResponse
    {
        if (! $pegawai->rekening) return ApiResponse::error('Data Rekening tidak ditemukan.', 404);

        $validated = $request->validate([
            'nama_bank'   => ['sometimes', 'required', 'in:BNI,Mandiri,BTN,BRI,Bank Jatim'],
            'no_rekening' => ['sometimes', 'required', 'string', 'max:30'],
            'atas_nama'   => ['sometimes', 'required', 'string', 'max:100'],
        ]);

        $pegawai->rekening->update($validated);
        return ApiResponse::success($pegawai->rekening, 'Data Rekening berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai): JsonResponse
    {
        if (! $pegawai->rekening) return ApiResponse::error('Data Rekening tidak ditemukan.', 404);
        $pegawai->rekening->delete();
        return ApiResponse::success(null, 'Data Rekening berhasil dihapus.');
    }
}
