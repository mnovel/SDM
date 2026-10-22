<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterLiburRequest extends FormRequest
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
            'nama' => ['string', 'max:255'],
            'tanggal_libur' => ['date'],
            'jenis_libur' => ['in:Nasional,Regional,Lokal'],
            'status' => ['in:Aktif,Tidak Aktif'],
        ];
    }
}
