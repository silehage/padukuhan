<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Penduduk::join('kartu_keluarga', 'kartu_keluarga.id', 'penduduk.kartu_keluarga_id')
            ->select(
                'kartu_keluarga.nomor',
                'penduduk.nama_lengkap',
                'penduduk.nik',
                'penduduk.Jenis_kelamin',
                'penduduk.tempat_lahir',
                'penduduk.tanggal_lahir',
                'kartu_keluarga.alamat',
                'penduduk.agama',
                'penduduk.pendidikan',
                'penduduk.jenis_pekerjaan',
                'penduduk.golongan_darah',
                'penduduk.status_perkawinan',
                'penduduk.tanggal_perkawinan',
                'penduduk.status_hubungan_keluarga',
                'penduduk.kewarganegaraan',
                'penduduk.no_paspor',
                'penduduk.no_kitap',
                'penduduk.nama_ayah',
                'penduduk.nama_ibu',
            )->get();
    }

    public function headings(): array
    {
        return [
            'NO KK',
            'NAMA LENGKAP',
            'NIK',
            'JENIS KELAMIN',
            'TEMPAT LAHIR',
            'TGL LAHIR',
            'ALAMAT',
            'AGAMA',
            'PENDIDIKAN',
            'JENIS PEKERJAAN',
            'GOLONGAN DARAH',
            'STATUS PERKAWINAN',
            'TGL PERKAWINAN',
            'STATUS HUBUNGAN KELUARGA',
            'KWEARGANEGARAAN',
            'NO PASPOR',
            'NO KITAP',
            'NAMA AYAH',
            'NAMA IBU',
        ];
    }
}
