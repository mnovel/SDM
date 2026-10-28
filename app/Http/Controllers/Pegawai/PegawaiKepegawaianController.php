<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiKepegawaian;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PegawaiKepegawaianController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        $data = $pegawai->riwayat_kepegawaian() // FIX: riwayat_kepegawaian
            ->with(['unit', 'jabatan', 'status_pegawai']) // FIX: Sesuaikan nama relasi
            ->orderBy('tmt_awal', 'desc')
            ->get();

        return ApiResponse::success($data, 'Daftar Kepegawaian Pegawai berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'master_status_pegawai_id' => ['required', 'exists:master_status_pegawai,id'],
            'master_unit_id'           => ['required', 'exists:master_unit,id'],
            'master_jabatan_id'        => ['required', 'exists:master_jabatan,id'],
            'tmt_awal'                 => ['required', 'date'],
            'tmt_akhir'                => ['nullable', 'date', 'after_or_equal:tmt_awal'],
            'is_aktif'                 => ['boolean'],
        ]);

        $kepegawaian = $pegawai->riwayat_kepegawaian()->create($validated);

        return ApiResponse::success(
            $kepegawaian->load(['unit', 'jabatan', 'status_pegawai']),
            'Data Kepegawaian berhasil ditambahkan.',
            201
        );
    }

    public function show(Pegawai $pegawai, PegawaiKepegawaian $kepegawaian): JsonResponse
    {
        if ($kepegawaian->pegawai_id !== $pegawai->id) {
            return ApiResponse::error('Data tidak ditemukan untuk pegawai ini.', 404);
        }

        return ApiResponse::success(
            $kepegawaian->load(['unit', 'jabatan', 'status_pegawai']),
            'Detail Kepegawaian.'
        );
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiKepegawaian $kepegawaian): JsonResponse
    {
        if ($kepegawaian->pegawai_id !== $pegawai->id) {
            return ApiResponse::error('Data tidak ditemukan untuk pegawai ini.', 404);
        }

        $validated = $request->validate([
            'master_status_pegawai_id' => ['sometimes', 'required', 'exists:master_status_pegawai,id'],
            'master_unit_id'           => ['sometimes', 'required', 'exists:master_unit,id'],
            'master_jabatan_id'        => ['sometimes', 'required', 'exists:master_jabatan,id'],
            'tmt_awal'                 => ['sometimes', 'required', 'date'],
            'tmt_akhir'                => ['sometimes', 'nullable', 'date', 'after_or_equal:tmt_awal'],
            'is_aktif'                 => ['sometimes', 'boolean'],
        ]);

        $kepegawaian->update($validated);

        return ApiResponse::success(
            $kepegawaian->load(['unit', 'jabatan', 'status_pegawai']),
            'Data Kepegawaian berhasil diperbarui.'
        );
    }

    public function destroy(Pegawai $pegawai, PegawaiKepegawaian $kepegawaian): JsonResponse
    {
        if ($kepegawaian->pegawai_id !== $pegawai->id) {
            return ApiResponse::error('Data tidak ditemukan untuk pegawai ini.', 404);
        }

        $kepegawaian->delete();

        return ApiResponse::success(null, 'Data Kepegawaian berhasil dihapus.');
    }
}
