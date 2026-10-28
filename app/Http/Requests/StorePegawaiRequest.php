<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gelar_depan'           => ['nullable', 'string', 'max:50'],
            'nama'                  => ['required', 'string', 'max:255'],
            'gelar_belakang'        => ['nullable', 'string', 'max:50'],
            'nip'                   => ['required', 'string', 'max:30', 'unique:pegawai,nip'],
            'jenis_identitas'       => ['required', 'in:KTP,SIM,PASSPORT'],
            'no_identitas'          => ['required', 'string', 'max:255', 'unique:pegawai,no_identitas'],
            'tempat_lahir'          => ['required', 'string', 'max:255'],
            'tanggal_lahir'         => ['required', 'date'],
            'jenis_kelamin'         => ['required', 'in:Laki-Laki,Perempuan'],

            // VALIDASI NAMA BERSIH (Tanpa master_)
            'agama_id'              => ['required', 'exists:master_agama,id'],
            'pendidikan_id'         => ['required', 'exists:master_pendidikan,id'],
            'status_pernikahan_id'  => ['required', 'exists:master_status_pernikahan,id'],

            'no_hp'                 => ['nullable', 'string', 'max:20'],
            'no_hp_darurat'         => ['nullable', 'string', 'max:20'],
            'email'                 => ['nullable', 'email', 'max:255'],
            'email_rs'              => ['nullable', 'email', 'max:255'],

            'provinsi_id'           => ['required', 'exists:master_provinsi,id'],
            'kota_id'               => ['required', 'exists:master_kota,id'],
            'kecamatan_id'          => ['required', 'exists:master_kecamatan,id'],
            'kelurahan_id'          => ['required', 'exists:master_kelurahan,id'],
            'alamat'                => ['required', 'string', 'max:255'],
            'kode_pos'              => ['required', 'string', 'max:10'],

            'provinsi_domisili_id'  => ['nullable', 'exists:master_provinsi,id'],
            'kota_domisili_id'      => ['nullable', 'exists:master_kota,id'],
            'kecamatan_domisili_id' => ['nullable', 'exists:master_kecamatan,id'],
            'kelurahan_domisili_id' => ['nullable', 'exists:master_kelurahan,id'],
            'alamat_domisili'       => ['nullable', 'string', 'max:255'],
            'kode_pos_domisili'     => ['nullable', 'string', 'max:10'],

            'foto'                  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
