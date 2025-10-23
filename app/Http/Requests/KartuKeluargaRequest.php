<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KartuKeluargaRequest extends FormRequest
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
            'nomor' => 'required|numeric|digits:16',
            'kepala_keluarga' => 'required',
            'alamat' => 'required',
            'rt_rw' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'kodepos' => 'required|numeric',
        ];
    }
    protected function prepareForValidation(): void 
    {
        $this->merge([
            'kepala_keluarga' => strtoupper($this->kepala_keluarga),
            'nomor' => str_replace(" ", "", $this->nomor)
        ]);
    }
}
