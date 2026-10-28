<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiAktivitasKerja;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiAktivitasKerjaController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->aktivitas_kerja()->orderBy('tanggal_mulai', 'desc')->get(), 'Riwayat Aktivitas Kerja berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'status_aktivitas' => ['required', 'string', 'max:255'],
            'no_surat'         => ['required', 'string', 'max:255'],
            'tanggal_mulai'    => ['required', 'date'],
            'tanggal_selesai'  => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'file_berkas'      => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'keterangan'       => ['nullable', 'string'],
        ]);

        if ($request->hasFile('file_berkas')) {
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/aktivitas-kerja', 'public');
        }

        $aktivitas = $pegawai->aktivitas_kerja()->create($validated);
        return ApiResponse::success($aktivitas, 'Data Aktivitas Kerja berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiAktivitasKerja $aktivitasKerja): JsonResponse
    {
        if ($aktivitasKerja->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($aktivitasKerja, 'Detail Aktivitas Kerja.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiAktivitasKerja $aktivitasKerja): JsonResponse
    {
        if ($aktivitasKerja->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'status_aktivitas' => ['sometimes', 'required', 'string', 'max:255'],
            'no_surat'         => ['sometimes', 'required', 'string', 'max:255'],
            'tanggal_mulai'    => ['sometimes', 'required', 'date'],
            'tanggal_selesai'  => ['sometimes', 'nullable', 'date'],
            'file_berkas'      => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'keterangan'       => ['sometimes', 'nullable', 'string'],
        ]);

        if ($request->hasFile('file_berkas')) {
            if ($aktivitasKerja->file_berkas && Storage::disk('public')->exists($aktivitasKerja->file_berkas)) {
                Storage::disk('public')->delete($aktivitasKerja->file_berkas);
            }
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/aktivitas-kerja', 'public');
        }

        $aktivitasKerja->update($validated);
        return ApiResponse::success($aktivitasKerja, 'Data Aktivitas Kerja berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiAktivitasKerja $aktivitasKerja): JsonResponse
    {
        if ($aktivitasKerja->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($aktivitasKerja->file_berkas && Storage::disk('public')->exists($aktivitasKerja->file_berkas)) {
            Storage::disk('public')->delete($aktivitasKerja->file_berkas);
        }
        $aktivitasKerja->delete();
        return ApiResponse::success(null, 'Data Aktivitas Kerja berhasil dihapus.');
    }
}
