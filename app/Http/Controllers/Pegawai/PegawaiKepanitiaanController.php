<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiKepanitiaan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiKepanitiaanController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->kepanitiaan()->orderBy('tanggal_mulai', 'desc')->get(), 'Data Kepanitiaan berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'kegiatan'        => ['required', 'string', 'max:255'],
            'no_surat'        => ['required', 'string', 'max:255'],
            'tingkat'         => ['required', 'string', 'max:255'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'file_berkas'     => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/kepanitiaan', 'public');
        }

        $kepanitiaan = $pegawai->kepanitiaan()->create($validated);
        return ApiResponse::success($kepanitiaan, 'Data Kepanitiaan berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiKepanitiaan $kepanitiaan): JsonResponse
    {
        if ($kepanitiaan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($kepanitiaan, 'Detail Kepanitiaan.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiKepanitiaan $kepanitiaan): JsonResponse
    {
        if ($kepanitiaan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'kegiatan'        => ['sometimes', 'required', 'string', 'max:255'],
            'no_surat'        => ['sometimes', 'required', 'string', 'max:255'],
            'tingkat'         => ['sometimes', 'required', 'string', 'max:255'],
            'tanggal_mulai'   => ['sometimes', 'required', 'date'],
            'tanggal_selesai' => ['sometimes', 'nullable', 'date'],
            'file_berkas'     => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            if ($kepanitiaan->file_berkas && Storage::disk('public')->exists($kepanitiaan->file_berkas)) {
                Storage::disk('public')->delete($kepanitiaan->file_berkas);
            }
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/kepanitiaan', 'public');
        }

        $kepanitiaan->update($validated);
        return ApiResponse::success($kepanitiaan, 'Data Kepanitiaan berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiKepanitiaan $kepanitiaan): JsonResponse
    {
        if ($kepanitiaan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($kepanitiaan->file_berkas && Storage::disk('public')->exists($kepanitiaan->file_berkas)) {
            Storage::disk('public')->delete($kepanitiaan->file_berkas);
        }
        $kepanitiaan->delete();
        return ApiResponse::success(null, 'Data Kepanitiaan berhasil dihapus.');
    }
}
