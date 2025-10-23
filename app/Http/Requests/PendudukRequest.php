<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class PendudukRequest extends FormRequest
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
            'nama_lengkap' => 'required',
            'nik' => 'required|numeric|digits:16',
            'Jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'pendidikan' => 'required',
            'jenis_pekerjaan' => 'required',
            'golongan_darah' => 'required',
            'status_perkawinan' => 'required',
            'tanggal_perkawinan' => 'nullable|date',
            'status_hubungan_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'no_paspor' => 'nullable',
            'no_kitap' => 'nullable',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ];
    }

    protected function prepareForValidation(): void
    {
        $tanggal_lahir = $this->tanggal_lahir;
        $timestamp = strtotime($tanggal_lahir);
        $tanggal_lahir = date("Y-m-d", $timestamp);

        $tanggal_perkawinan = '';

        if ($this->tanggal_perkawinan) {

            $tanggal_perkawinan = $this->tanggal_perkawinan;
            $timestamp = strtotime($tanggal_perkawinan);
            $tanggal_perkawinan = date("Y-m-d", $timestamp);
        }

        $this->merge([
            'tanggal_lahir' => $tanggal_lahir,
            'tanggal_perkawinan' => $tanggal_perkawinan,
            'nama_lengkap' => strtoupper($this->nama_lengkap),
            'tempat_lahir' => strtoupper($this->tempat_lahir),
            'nama_ayah' => strtoupper($this->nama_ayah),
            'nama_ibu' => strtoupper($this->nama_ibu),
            'nik' => str_replace(" ", "", $this->nik)
        ]);
    }
}
