<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMasterStatusPernikahanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'max:150', 'unique:master_status_pernikahan,nama'],
            'status' => ['required', 'in:Aktif,Tidak Aktif']
        ];
    }
}
