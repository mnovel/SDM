<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiNakes;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiNakesController extends Controller
{
    public function index(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success($pegawai->nakes()->orderBy('created_at', 'desc')->get(), 'Daftar Nakes berhasil diambil.');
    }

    public function store(Request $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validate([
            'profesi'           => ['required', 'string', 'max:255'],
            'no_str'            => ['required', 'string', 'max:50'],
            'tgl_berakhir_str'  => ['required', 'date'],
            'file_str'          => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'no_sip'            => ['nullable', 'string', 'max:50'],
            'tgl_berakhir_sip'  => ['nullable', 'date'],
            'file_sip'          => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'no_sik'            => ['nullable', 'string', 'max:50'],
        ]);

        if ($request->hasFile('file_str')) {
            $validated['file_str'] = $request->file('file_str')->store('pegawai/nakes', 'public');
        }
        if ($request->hasFile('file_sip')) {
            $validated['file_sip'] = $request->file('file_sip')->store('pegawai/nakes', 'public');
        }

        $nakes = $pegawai->nakes()->create($validated);
        return ApiResponse::success($nakes, 'Data Nakes berhasil ditambahkan.', 201);
    }

    public function show(Pegawai $pegawai, PegawaiNakes $nakes): JsonResponse
    {
        if ($nakes->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);
        return ApiResponse::success($nakes, 'Detail Nakes.');
    }

    public function update(Request $request, Pegawai $pegawai, PegawaiNakes $nakes): JsonResponse
    {
        if ($nakes->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        $validated = $request->validate([
            'profesi'           => ['sometimes', 'required', 'string', 'max:255'],
            'no_str'            => ['sometimes', 'required', 'string', 'max:50'],
            'tgl_berakhir_str'  => ['sometimes', 'required', 'date'],
            'file_str'          => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'no_sip'            => ['sometimes', 'nullable', 'string', 'max:50'],
            'tgl_berakhir_sip'  => ['sometimes', 'nullable', 'date'],
            'file_sip'          => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'no_sik'            => ['sometimes', 'nullable', 'string', 'max:50'],
        ]);

        if ($request->hasFile('file_str')) {
            if ($nakes->file_str && Storage::disk('public')->exists($nakes->file_str)) {
                Storage::disk('public')->delete($nakes->file_str);
            }
            $validated['file_str'] = $request->file('file_str')->store('pegawai/nakes', 'public');
        }
        if ($request->hasFile('file_sip')) {
            if ($nakes->file_sip && Storage::disk('public')->exists($nakes->file_sip)) {
                Storage::disk('public')->delete($nakes->file_sip);
            }
            $validated['file_sip'] = $request->file('file_sip')->store('pegawai/nakes', 'public');
        }

        $nakes->update($validated);
        return ApiResponse::success($nakes, 'Data Nakes berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai, PegawaiNakes $nakes): JsonResponse
    {
        if ($nakes->pegawai_id !== $pegawai->id) return ApiResponse::error('Data tidak ditemukan.', 404);

        if ($nakes->file_str && Storage::disk('public')->exists($nakes->file_str)) {
            Storage::disk('public')->delete($nakes->file_str);
        }
        if ($nakes->file_sip && Storage::disk('public')->exists($nakes->file_sip)) {
            Storage::disk('public')->delete($nakes->file_sip);
        }

        $nakes->delete();
        return ApiResponse::success(null, 'Data Nakes berhasil dihapus.');
    }
}
