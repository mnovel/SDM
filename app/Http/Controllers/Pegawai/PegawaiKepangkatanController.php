<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiKepangkatan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiKepangkatanController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->kepangkatan()->with('pangkat')->orderBy('tmt', 'desc')->get(), 'Riwayat Kepangkatan berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'status_kerja'      => ['required', 'string', 'max:50'],
            'master_pangkat_id' => ['required', 'exists:master_pangkat,id'],
            'no_sk'             => ['required', 'string', 'max:255'],
            'tmt'               => ['required', 'date'],
            'berkala'           => ['nullable', 'date', 'after_or_equal:tmt'],
            'file_berkas'       => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/kepangkatan', 'public');
        }

        $kepangkatan = $pegawai->kepangkatan()->create($validated);
        return ApiResponse::success($kepangkatan->load('pangkat'), 'Data Kepangkatan berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiKepangkatan $kepangkatan): JsonResponse
    {
        if ($kepangkatan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($kepangkatan->load('pangkat'), 'Detail Kepangkatan.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiKepangkatan $kepangkatan): JsonResponse
    {
        if ($kepangkatan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'status_kerja'      => ['sometimes', 'required', 'string', 'max:50'],
            'master_pangkat_id' => ['sometimes', 'required', 'exists:master_pangkat,id'],
            'no_sk'             => ['sometimes', 'required', 'string', 'max:255'],
            'tmt'               => ['sometimes', 'required', 'date'],
            'berkala'           => ['sometimes', 'nullable', 'date'],
            'file_berkas'       => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            if ($kepangkatan->file_berkas && Storage::disk('public')->exists($kepangkatan->file_berkas)) {
                Storage::disk('public')->delete($kepangkatan->file_berkas);
            }
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/kepangkatan', 'public');
        }

        $kepangkatan->update($validated);
        return ApiResponse::success($kepangkatan->load('pangkat'), 'Data Kepangkatan berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiKepangkatan $kepangkatan): JsonResponse
    {
        if ($kepangkatan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($kepangkatan->file_berkas && Storage::disk('public')->exists($kepangkatan->file_berkas)) {
            Storage::disk('public')->delete($kepangkatan->file_berkas);
        }
        $kepangkatan->delete();
        return ApiResponse::success(null, 'Data Kepangkatan berhasil dihapus.');
    }
}
