<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiDokumen;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiDokumenController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->dokumen()->orderBy('created_at', 'desc')->get(), 'Daftar Dokumen berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'jenis_dokumen'      => ['required', 'string', 'max:255'],
            'nomor_dokumen'      => ['nullable', 'string', 'max:255'],
            'file_path'          => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'tanggal_kadaluarsa' => ['nullable', 'date'],
        ]);

        $validated['file_path'] = $request->file('file_path')->store('pegawai/dokumen', 'public');
        $dokumen = $pegawai->dokumen()->create($validated);

        return ApiResponse::success($dokumen, 'Dokumen berhasil diunggah.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiDokumen $dokumen): JsonResponse
    {
        if ($dokumen->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($dokumen, 'Detail Dokumen.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiDokumen $dokumen): JsonResponse
    {
        if ($dokumen->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'jenis_dokumen'      => ['sometimes', 'required', 'string', 'max:255'],
            'nomor_dokumen'      => ['sometimes', 'nullable', 'string', 'max:255'],
            'file_path'          => ['sometimes', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'tanggal_kadaluarsa' => ['sometimes', 'nullable', 'date'],
        ]);

        if ($request->hasFile('file_path')) {
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('pegawai/dokumen', 'public');
        }

        $dokumen->update($validated);
        return ApiResponse::success($dokumen, 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiDokumen $dokumen): JsonResponse
    {
        if ($dokumen->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        $dokumen->delete();
        return ApiResponse::success(null, 'Dokumen berhasil dihapus.');
    }

    public function download(Pegawai $pegawai, PegawaiDokumen $dokumen)
    {
        if ($dokumen->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $path = Storage::disk('public')->path($dokumen->file_path);
        if (!file_exists($path)) return ApiResponse::error('File fisik tidak ditemukan di server.', 404);

        return response()->download($path);
    }
}
