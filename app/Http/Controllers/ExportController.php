<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Exports\DataExport;
use App\Models\KartuKeluarga;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new DataExport, 'penduduk-rt-05.xlsx');
    }
    public function dataIndukPadukuhan()
    {
        $data = KartuKeluarga::with('items')->get();

        // return view('pdf.dataIndukPadukuhan', compact('data'));

        $dompdf = Pdf::loadView('pdf.dataIndukPadukuhan', compact('data'));
        $filename = 'BUKU_INDUK_PADUKUHAN_RT_05.pdf';
        return $dompdf->stream($filename);
    }
    public function dataIndukPenduduk()
    {
        $data = KartuKeluarga::with('items')->get();
        // return view('pdf.dataIndukPenduduk', compact('data'));
        $dompdf = Pdf::loadView('pdf.dataIndukPenduduk', compact('data'));
        $filename = 'BUKU_INDUK_PENDUDUK_(BIP)_RT.pdf';
        return $dompdf->stream($filename);
    }
    public function exportKas()
    {
        $tahun = 2025;

        // Ambil data kas tahun 2025
        $kas = DB::table('kas')
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->orderBy('in_out', 'asc')
            ->get();

        // Group by bulan (Y-m)
        $grouped = $kas->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y-m');
        });

        $data = $grouped->map(function ($items, $key) {
            $carbon = Carbon::createFromFormat('Y-m', $key);
            $label = $carbon->translatedFormat('F Y'); // Contoh: Januari 2025

            $total_pendapatan = $items->where('in_out', 'IN')->sum('jumlah');
            $total_pengeluaran = $items->where('in_out', 'OUT')->sum('jumlah');

            return [
                'label' => $label,
                'items' => $items->values(),
                'total_pendapatan' => $total_pendapatan,
                'total_pengeluaran' => $total_pengeluaran,
            ];
        })->values();


        $data = collect();

        // Loop 12 bulan penuh
        for ($bulan = 1; $bulan <= 11; $bulan++) {
            $carbon = Carbon::create($tahun, $bulan, 1);
            $key = $carbon->format('Y-m');
            $label = $carbon->translatedFormat('F Y'); // Contoh: Januari 2024

            $items = $grouped->get($key, collect());

            $total_pendapatan = $items->where('in_out', 'IN')->sum('jumlah');
            $total_pengeluaran = $items->where('in_out', 'OUT')->sum('jumlah');

            $data->push([
                'label' => $label,
                'items' => $items->values(),
                'total_pendapatan' => (int) $total_pendapatan,
                'total_pengeluaran' => (int) $total_pengeluaran,
            ]);
        }

        // dd($data);

        // return view('pdf.kas', compact('data'));

        $dompdf = Pdf::loadView('pdf.kas', compact('data'));
        $dompdf->setPaper('A4', 'portrait');
        $filename = 'BUKU_KAS_RT_05.pdf';
        return $dompdf->stream($filename);


        return response()->json($result);
    }
    public function exportInventaris()
    {
        $tahun = 2025;

        // Ambil data kas tahun 2024
        $data = DB::table('inventaris')
            ->whereYear('tanggal', '<=', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        // return view('pdf.inventaris', compact('data'));

        $dompdf = Pdf::loadView('pdf.inventaris', compact('data'));
        $filename = 'BUKU_INVENTARIS_RT_05.pdf';
        return $dompdf->stream($filename);


        return response()->json($result);
    }
    public function exportPengurus()
    {
        $result = Penduduk::select(
            'penduduk.*',
            'pengurus.jabatan',
            'kartu_keluarga.alamat'
        )
            ->join('pengurus', 'pengurus.id', 'penduduk.pengurus_id')
            ->join('kartu_keluarga', 'kartu_keluarga.id', 'penduduk.kartu_keluarga_id')
            ->orderBy('pengurus.id')
            ->get();

        $data = [];

        $key = 0;

        for ($i = 0; $i < $result->count(); $i++) {

            if ($i % 12 == 0) {
                $key++;
                $data[$key][] = $result[$i]; 
            }else {

                Log::debug($key);

                // dd($key);
                $data[$key][] = $result[$i];
            }
        }

        // dd($data);

        // return view('pdf.pengurus', compact('data'));

        $dompdf = Pdf::loadView('pdf.pengurus', compact('data'));
        $dompdf->setPaper('folio', 'landscape');
        $filename = 'pengurus_RT_05.pdf';
        return $dompdf->stream($filename);


        return response()->json($result);
    }
}
