<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use Illuminate\Http\Request;
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
    public function exportPdf()
    {
        $data = KartuKeluarga::with('items')->get();

        // return view('pdf.list', compact('data'));

        // $dimensions =  array(0, 0, ,210, 330);

        $dompdf = Pdf::loadView('pdf.list', compact('data'));
        $dompdf->setPaper('letter', 'landscape');
        $filename = 'BUKU_INDUK_PADUKUHAN_RT_05';
        return $dompdf->stream($filename);

        return view('pdf.list', compact('data'));
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
}
