<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMasterStatusPegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'max:150', 'unique:master_status_pegawai,nama,' . $this->request('statusPegawai')->id],
            'status' => ['required', 'in:Akif,Tidak Aktif']
        ];
    }
}
