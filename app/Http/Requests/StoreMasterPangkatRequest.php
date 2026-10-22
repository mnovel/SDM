<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMasterPangkatRequest extends FormRequest
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
            'pangkat' => ['required', 'string', 'max:100', 'unique:master_pangkat,pangkat'],
            'golongan' => ['required', 'string', 'max:50'],
            'pendidikan' => ['required', 'exists:master_pendidikan,id'],
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ];
    }
}
