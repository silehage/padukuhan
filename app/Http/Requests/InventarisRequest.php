<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventarisRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string'],
            'asal_barang' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'jumlah' => ['required', 'numeric'],
            'satuan' => ['required', 'string'],
            'tempat_penyimpanan' => ['required', 'string'],
            'kondisi_barang' => ['required', 'string'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
