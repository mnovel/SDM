<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pegawai = $this->route('pegawai');
        $id = $pegawai instanceof \App\Models\Pegawai ? $pegawai->id : $pegawai;

        return [
            'gelar_depan'           => ['sometimes', 'nullable', 'string', 'max:50'],
            'nama'                  => ['sometimes', 'required', 'string', 'max:255'],
            'gelar_belakang'        => ['sometimes', 'nullable', 'string', 'max:50'],
            'nip'                   => ['sometimes', 'required', 'string', 'max:30', Rule::unique('pegawai', 'nip')->ignore($id)],
            'jenis_identitas'       => ['sometimes', 'required', 'in:KTP,SIM,PASSPORT'],
            'no_identitas'          => ['sometimes', 'required', 'string', 'max:255', Rule::unique('pegawai', 'no_identitas')->ignore($id)],
            'tempat_lahir'          => ['sometimes', 'required', 'string', 'max:255'],
            'tanggal_lahir'         => ['sometimes', 'required', 'date'],
            'jenis_kelamin'         => ['sometimes', 'required', 'in:Laki-Laki,Perempuan'],

            'agama_id'              => ['sometimes', 'required', 'exists:master_agama,id'],
            'pendidikan_id'         => ['sometimes', 'required', 'exists:master_pendidikan,id'],
            'status_pernikahan_id'  => ['sometimes', 'required', 'exists:master_status_pernikahan,id'],

            'no_hp'                 => ['sometimes', 'nullable', 'string', 'max:20'],
            'no_hp_darurat'         => ['sometimes', 'nullable', 'string', 'max:20'],
            'email'                 => ['sometimes', 'nullable', 'email', 'max:255'],
            'email_rs'              => ['sometimes', 'nullable', 'email', 'max:255'],

            'provinsi_id'           => ['sometimes', 'required', 'exists:master_provinsi,id'],
            'kota_id'               => ['sometimes', 'required', 'exists:master_kota,id'],
            'kecamatan_id'          => ['sometimes', 'required', 'exists:master_kecamatan,id'],
            'kelurahan_id'          => ['sometimes', 'required', 'exists:master_kelurahan,id'],
            'alamat'                => ['sometimes', 'required', 'string', 'max:255'],
            'kode_pos'              => ['sometimes', 'required', 'string', 'max:10'],

            'provinsi_domisili_id'  => ['sometimes', 'nullable', 'exists:master_provinsi,id'],
            'kota_domisili_id'      => ['sometimes', 'nullable', 'exists:master_kota,id'],
            'kecamatan_domisili_id' => ['sometimes', 'nullable', 'exists:master_kecamatan,id'],
            'kelurahan_domisili_id' => ['sometimes', 'nullable', 'exists:master_kelurahan,id'],
            'alamat_domisili'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'kode_pos_domisili'     => ['sometimes', 'nullable', 'string', 'max:10'],

            'foto'                  => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
