<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiPendidikan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiPendidikanController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        $data = $pegawai->pendidikan()->with('pendidikan')->orderBy('tahun_lulus', 'desc')->get();
        return ApiResponse::success($data, 'Riwayat Pendidikan berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'master_pendidikan_id' => ['required', 'exists:master_pendidikan,id'],
            'nama_institusi'       => ['required', 'string', 'max:255'],
            'jurusan'              => ['required', 'string', 'max:255'],
            'tahun_lulus'          => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'no_ijazah'            => ['nullable', 'string', 'max:255'],
            'file_ijazah'          => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_ijazah')) {
            $validated['file_ijazah'] = $request->file('file_ijazah')->store('pegawai/pendidikan', 'public');
        }

        $pendidikan = $pegawai->pendidikan()->create($validated);
        return ApiResponse::success($pendidikan->load('pendidikan'), 'Riwayat Pendidikan berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiPendidikan $pendidikan): JsonResponse
    {
        if ($pendidikan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($pendidikan->load('pendidikan'), 'Detail Riwayat Pendidikan.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiPendidikan $pendidikan): JsonResponse
    {
        if ($pendidikan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'master_pendidikan_id' => ['sometimes', 'required', 'exists:master_pendidikan,id'],
            'nama_institusi'       => ['sometimes', 'required', 'string', 'max:255'],
            'jurusan'              => ['sometimes', 'required', 'string', 'max:255'],
            'tahun_lulus'          => ['sometimes', 'required', 'integer'],
            'no_ijazah'            => ['sometimes', 'nullable', 'string', 'max:255'],
            'file_ijazah'          => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('file_ijazah')) {
            if ($pendidikan->file_ijazah && Storage::disk('public')->exists($pendidikan->file_ijazah)) {
                Storage::disk('public')->delete($pendidikan->file_ijazah);
            }
            $validated['file_ijazah'] = $request->file('file_ijazah')->store('pegawai/pendidikan', 'public');
        }

        $pendidikan->update($validated);
        return ApiResponse::success($pendidikan->load('pendidikan'), 'Riwayat Pendidikan berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiPendidikan $pendidikan): JsonResponse
    {
        if ($pendidikan->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($pendidikan->file_ijazah && Storage::disk('public')->exists($pendidikan->file_ijazah)) {
            Storage::disk('public')->delete($pendidikan->file_ijazah);
        }
        $pendidikan->delete();
        return ApiResponse::success(null, 'Riwayat Pendidikan berhasil dihapus.');
    }
}
