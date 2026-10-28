<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\Models\Pegawai;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    private function mapVariables(array $data): array
    {
        $mapping = [
            'agama_id'              => 'master_agama_id',
            'pendidikan_id'         => 'master_pendidikan_id',
            'status_pernikahan_id'  => 'master_status_pernikahan_id',
            'provinsi_id'           => 'master_provinsi_id',
            'kota_id'               => 'master_kota_id',
            'kecamatan_id'          => 'master_kecamatan_id',
            'kelurahan_id'          => 'master_kelurahan_id',
            'provinsi_domisili_id'  => 'master_provinsi_domisili_id',
            'kota_domisili_id'      => 'master_kota_domisili_id',
            'kecamatan_domisili_id' => 'master_kecamatan_domisili_id',
            'kelurahan_domisili_id' => 'master_kelurahan_domisili_id',
        ];

        foreach ($mapping as $apiKey => $dbColumn) {
            if (array_key_exists($apiKey, $data)) {
                $data[$dbColumn] = $data[$apiKey];
                unset($data[$apiKey]);
            }
        }

        return $data;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Pegawai::query()
            ->select(['id', 'gelar_depan', 'nama', 'gelar_belakang', 'nip', 'no_hp', 'email', 'jenis_kelamin', 'foto'])
            ->with([
                'kepegawaian_aktif.unit',
                'kepegawaian_aktif.jabatan',
                'kepegawaian_aktif.status_pegawai'
            ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('unit_id')) {
            $query->whereHas('kepegawaian_aktif', function ($q) use ($request) {
                $q->where('master_unit_id', $request->unit_id);
            });
        }

        if ($request->filled('jabatan_id')) {
            $query->whereHas('kepegawaian_aktif', function ($q) use ($request) {
                $q->where('master_jabatan_id', $request->jabatan_id);
            });
        }

        $perPage = (int) $request->get('per_page', 15);
        $data = $query->orderBy('nama', 'asc')->paginate($perPage);

        return ApiResponse::paginated($data, 'Daftar Pegawai berhasil diambil.');
    }

    public function store(StorePegawaiRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated = $this->mapVariables($validated);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai/foto', 'public');
        }

        $pegawai = Pegawai::create($validated);

        return ApiResponse::success(
            $pegawai->load(['agama', 'pendidikan_terakhir', 'status_pernikahan']),
            'Data Pegawai berhasil ditambahkan.',
            201
        );
    }

    public function show(Pegawai $pegawai): JsonResponse
    {
        return ApiResponse::success(
            $pegawai->load([
                'agama',
                'pendidikan_terakhir',
                'status_pernikahan',
                'provinsi',
                'kota',
                'kecamatan',
                'kelurahan',
                'provinsi_domisili',
                'kota_domisili',
                'kecamatan_domisili',
                'kelurahan_domisili'
            ]),
            'Detail Pegawai.'
        );
    }

    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai): JsonResponse
    {
        $validated = $request->validated();

        $validated = $this->mapVariables($validated);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pegawai/foto', 'public');
        }

        $pegawai->update($validated);

        return ApiResponse::success(
            $pegawai->load(['agama', 'pendidikan_terakhir', 'status_pernikahan']),
            'Data Pegawai berhasil diperbarui.'
        );
    }

    public function destroy(Pegawai $pegawai): JsonResponse
    {
        $pegawai->delete();
        return ApiResponse::success(null, 'Data Pegawai berhasil dihapus.');
    }

    public function profil(Pegawai $pegawai): JsonResponse
    {
        $pegawai->load([
            'agama',
            'pendidikan_terakhir',
            'status_pernikahan',
            'provinsi',
            'kota',
            'kecamatan',
            'kelurahan',
            'provinsi_domisili',
            'kota_domisili',
            'kecamatan_domisili',
            'kelurahan_domisili',
            'riwayat_kepegawaian.unit',
            'riwayat_kepegawaian.jabatan',
            'riwayat_kepegawaian.status_pegawai',
            'nakes',
            'pendidikan.pendidikan',
            'keluarga',
            'rekening',
            'dokumen',
            'kepangkatan.pangkat',
            'riwayat_kerja',
            'kepanitiaan',
            'jabatan_struktural.jabatan',
            'jabatan_struktural.unit',
            'aktivitas_kerja'
        ]);

        return ApiResponse::success($pegawai, 'Profil lengkap Pegawai berhasil diambil.');
    }

    public function restore(string $id): JsonResponse
    {
        $pegawai = Pegawai::withTrashed()->findOrFail($id);

        if (! $pegawai->trashed()) {
            return ApiResponse::error('Pegawai ini tidak dalam status terhapus.', 400);
        }

        $pegawai->restore();

        return ApiResponse::success($pegawai, 'Data Pegawai berhasil dikembalikan.');
    }
}
