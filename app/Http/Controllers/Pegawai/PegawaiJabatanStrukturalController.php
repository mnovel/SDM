<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiJabatanStruktural;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiJabatanStrukturalController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->jabatan_struktural()->with(['jabatan', 'unit'])->orderBy('tanggal_awal', 'desc')->get(), 'Riwayat Jabatan Struktural berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'master_jabatan_id' => ['required', 'exists:master_jabatan,id'],
            'master_unit_id'    => ['nullable', 'exists:master_unit,id'],
            'no_sk'             => ['required', 'string', 'max:255'],
            'tanggal_awal'      => ['required', 'date'],
            'file_berkas'       => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/jabatan-struktural', 'public');
        }

        $jabatan = $pegawai->jabatan_struktural()->create($validated);
        return ApiResponse::success($jabatan->load(['jabatan', 'unit']), 'Data Jabatan Struktural berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiJabatanStruktural $jabatanStruktural): JsonResponse
    {
        if ($jabatanStruktural->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($jabatanStruktural->load(['jabatan', 'unit']), 'Detail Jabatan Struktural.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiJabatanStruktural $jabatanStruktural): JsonResponse
    {
        if ($jabatanStruktural->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'master_jabatan_id' => ['sometimes', 'required', 'exists:master_jabatan,id'],
            'master_unit_id'    => ['sometimes', 'nullable', 'exists:master_unit,id'],
            'no_sk'             => ['sometimes', 'required', 'string', 'max:255'],
            'tanggal_awal'      => ['sometimes', 'required', 'date'],
            'file_berkas'       => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_berkas')) {
            if ($jabatanStruktural->file_berkas && Storage::disk('public')->exists($jabatanStruktural->file_berkas)) {
                Storage::disk('public')->delete($jabatanStruktural->file_berkas);
            }
            $validated['file_berkas'] = $request->file('file_berkas')->store('pegawai/jabatan-struktural', 'public');
        }

        $jabatanStruktural->update($validated);
        return ApiResponse::success($jabatanStruktural->load(['jabatan', 'unit']), 'Data Jabatan Struktural berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiJabatanStruktural $jabatanStruktural): JsonResponse
    {
        if ($jabatanStruktural->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($jabatanStruktural->file_berkas && Storage::disk('public')->exists($jabatanStruktural->file_berkas)) {
            Storage::disk('public')->delete($jabatanStruktural->file_berkas);
        }
        $jabatanStruktural->delete();
        return ApiResponse::success(null, 'Data Jabatan Struktural berhasil dihapus.');
    }
}
