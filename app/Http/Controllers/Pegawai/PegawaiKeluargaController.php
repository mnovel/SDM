<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiKeluarga;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PegawaiKeluargaController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->keluarga()->orderBy('tanggal_lahir', 'asc')->get(), 'Data Keluarga berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'nama'           => ['required', 'string', 'max:255'],
            'hubungan'       => ['required', 'in:Suami,Istri,Anak,Ayah,Ibu'],
            'nik'            => ['nullable', 'string', 'max:16'],
            'no_bpjs'        => ['nullable', 'string', 'max:20'],
            'tanggal_lahir'  => ['required', 'date'],
            'is_tanggungan'  => ['boolean'],
        ]);

        $keluarga = $pegawai->keluarga()->create($validated);
        return ApiResponse::success($keluarga, 'Data Keluarga berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiKeluarga $keluarga): JsonResponse
    {
        if ($keluarga->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($keluarga, 'Detail Data Keluarga.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiKeluarga $keluarga): JsonResponse
    {
        if ($keluarga->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'nama'           => ['sometimes', 'required', 'string', 'max:255'],
            'hubungan'       => ['sometimes', 'required', 'in:Suami,Istri,Anak,Ayah,Ibu'],
            'nik'            => ['sometimes', 'nullable', 'string', 'max:16'],
            'no_bpjs'        => ['sometimes', 'nullable', 'string', 'max:20'],
            'tanggal_lahir'  => ['sometimes', 'required', 'date'],
            'is_tanggungan'  => ['sometimes', 'boolean'],
        ]);

        $keluarga->update($validated);
        return ApiResponse::success($keluarga, 'Data Keluarga berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiKeluarga $keluarga): JsonResponse
    {
        if ($keluarga->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        $keluarga->delete();
        return ApiResponse::success(null, 'Data Keluarga berhasil dihapus.');
    }
}
