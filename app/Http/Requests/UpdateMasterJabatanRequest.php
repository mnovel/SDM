<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMasterJabatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jabatan = $this->route('jabatan');
        $id = $jabatan instanceof \App\Models\MasterJabatan ? $jabatan->id : $jabatan;

        return [
            'nama'         => ['sometimes', 'required', 'string', 'max:255', Rule::unique('master_jabatan', 'nama')->ignore($id)],
            'nama_singkat' => ['sometimes', 'required', 'string', 'max:30', Rule::unique('master_jabatan', 'nama_singkat')->ignore($id)],
            'status'       => ['sometimes', 'required', 'in:Aktif,Tidak Aktif'],
            'unit_id'      => ['sometimes', 'required', 'uuid', 'exists:master_unit,id'],
            'kode_jabatan' => ['sometimes', 'nullable', 'string', 'max:50'],
        ];
    }
}
