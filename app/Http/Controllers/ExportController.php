<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use App\Models\KartuKeluarga;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
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
        // $dimensions =  [0, 0, 612, 792];
        $dimensions =  array(0, 0, 610, 936);
        $dompdf->setPaper($dimensions, 'landscape');
        $filename = 'BUKU_INDUK_PADUKUHAN_RT_05';
        return $dompdf->stream($filename);
    }
    public function dataIndukPenduduk()
    {
        $data = KartuKeluarga::with('items')->get();
        // return view('pdf.dataIndukPenduduk', compact('data'));



        $dompdf = Pdf::loadView('pdf.dataIndukPenduduk', compact('data'));
        // $dimensions =  [0, 0, 612, 792];
          $dimensions =  array(0, 0, 610, 936);
        $dompdf->setPaper($dimensions, 'landscape');
        // $dompdf->setPaper('letter', 'landscape');
        $filename = 'BUKU_INDUK_PENDUDUK_(BIP)_RT';
        return $dompdf->stream($filename);
    }
    public function exportKas()
    {
        $tahun = 2024;

        // Ambil data kas tahun 2024
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
            $label = $carbon->translatedFormat('F Y'); // Contoh: Januari 2024

            $total_pendapatan = $items->where('in_out', 'IN')->sum('jumlah');
            $total_pengeluaran = $items->where('in_out', 'OUT')->sum('jumlah');

            return [
                'label' => $label,
                'items' => $items->values(),
                'total_pendapatan' => $total_pendapatan,
                'total_pengeluaran' => $total_pengeluaran,
            ];
        })->values();


        //  $data = collect();

        // // Loop 12 bulan penuh
        // for ($bulan = 1; $bulan <= 12; $bulan++) {
        //     $carbon = Carbon::create($tahun, $bulan, 1);
        //     $key = $carbon->format('Y-m');
        //     $label = $carbon->translatedFormat('F Y'); // Contoh: Januari 2024

        //     $items = $grouped->get($key, collect());

        //     $total_pendapatan = $items->where('in_out', 'IN')->sum('jumlah');
        //     $total_pengeluaran = $items->where('in_out', 'OUT')->sum('jumlah');

        //     $data->push([
        //         'label' => $label,
        //         'items' => $items->values(),
        //         'total_pendapatan' => (int) $total_pendapatan,
        //         'total_pengeluaran' => (int) $total_pengeluaran,
        //     ]);
        // }

        // dd($data);

        // return view('pdf.kas', compact('data'));

        $dompdf = Pdf::loadView('pdf.kas', compact('data'));
        $dompdf->setPaper('a4', 'portrait');
        $filename = 'BUKU_KAS_RT_05';
        return $dompdf->stream($filename);


        return response()->json($result);
    }
    public function exportInventaris()
    {
        $tahun = 2024;

        // Ambil data kas tahun 2024
        $data = DB::table('inventaris')
            ->whereYear('tanggal', '<=', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        // return view('pdf.inventaris', compact('data'));

        $dompdf = Pdf::loadView('pdf.inventaris', compact('data'));
        $dompdf->setPaper('a4', 'landscape');
        $filename = 'BUKU_INVENTARIS_RT_05';
        return $dompdf->stream($filename);


        return response()->json($result);
    }
}
