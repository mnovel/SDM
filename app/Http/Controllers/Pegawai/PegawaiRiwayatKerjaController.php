<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiRiwayatKerja;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiRiwayatKerjaController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->riwayat_kerja()->orderBy('tanggal_mulai', 'desc')->get(), 'Riwayat Kerja berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'no_surat'        => ['required', 'string', 'max:255'],
            'unit_kerja'      => ['required', 'string', 'max:255'],
            'klasifikasi'     => ['required', 'string', 'max:255'],
            'posisi'          => ['required', 'string', 'max:255'],
            'tanggal_mulai'   => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'file_berkas'     => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/riwayat-kerja', 'public');
        }

        $riwayat = $pegawai->riwayat_kerja()->create($validated);
        return ApiResponse::success($riwayat, 'Riwayat Kerja berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiRiwayatKerja $riwayatKerja): JsonResponse
    {
        if ($riwayatKerja->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($riwayatKerja, 'Detail Riwayat Kerja.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiRiwayatKerja $riwayatKerja): JsonResponse
    {
        if ($riwayatKerja->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'no_surat'        => ['sometimes', 'required', 'string', 'max:255'],
            'unit_kerja'      => ['sometimes', 'required', 'string', 'max:255'],
            'klasifikasi'     => ['sometimes', 'required', 'string', 'max:255'],
            'posisi'          => ['sometimes', 'required', 'string', 'max:255'],
            'tanggal_mulai'   => ['sometimes', 'required', 'date'],
            'tanggal_selesai' => ['sometimes', 'nullable', 'date'],
            'file_berkas'     => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            if ($riwayatKerja->file_berkas && Storage::disk('public')->exists($riwayatKerja->file_berkas)) {
                Storage::disk('public')->delete($riwayatKerja->file_berkas);
            }
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/riwayat-kerja', 'public');
        }

        $riwayatKerja->update($validated);
        return ApiResponse::success($riwayatKerja, 'Riwayat Kerja berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiRiwayatKerja $riwayatKerja): JsonResponse
    {
        if ($riwayatKerja->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($riwayatKerja->file_berkas && Storage::disk('public')->exists($riwayatKerja->file_berkas)) {
            Storage::disk('public')->delete($riwayatKerja->file_berkas);
        }
        $riwayatKerja->delete();
        return ApiResponse::success(null, 'Riwayat Kerja berhasil dihapus.');
    }
}
