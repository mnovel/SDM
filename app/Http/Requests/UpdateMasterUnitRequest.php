<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterUnitRequest extends FormRequest
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
        $id = $this->route('unit')?->id ?? $this->route('unit');

        return [
            'nama'         => ['sometimes', 'string', 'max:255', "unique:master_unit,nama,{$id}"],
            'nama_singkat' => ['sometimes', 'string', 'max:30',  "unique:master_unit,nama_singkat,{$id}"],
            'parent_id'    => ['sometimes', 'nullable', 'uuid', 'exists:master_unit,id'],
            'status'       => ['sometimes', 'in:Aktif,Tidak Aktif'],
        ];
    }
}
