<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterJabatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'         => ['required', 'string', 'max:255', 'unique:master_jabatan,nama'],
            'nama_singkat' => ['required', 'string', 'max:30', 'unique:master_jabatan,nama_singkat'],
            'status'       => ['required', 'in:Aktif,Tidak Aktif'],
            'unit_id'      => ['required', 'uuid', 'exists:master_unit,id'],
            'kode_jabatan' => ['nullable', 'string', 'max:50'],
        ];
    }
}
