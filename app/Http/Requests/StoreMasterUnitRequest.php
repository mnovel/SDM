<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMasterUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama'         => ['required', 'string', 'max:255', 'unique:master_unit,nama'],
            'nama_singkat' => ['required', 'string', 'max:30',  'unique:master_unit,nama_singkat'],
            'parent_id'    => ['nullable', 'uuid', 'exists:master_unit,id'],
            'status'       => ['sometimes', 'in:Aktif,Tidak Aktif'],
        ];
    }
}
