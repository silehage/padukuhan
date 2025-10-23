<?php

namespace App\Http\Controllers;

use App\Http\Requests\KasRequest;
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tgl = $request->date ?? now()->format('Y-m');

        $items = Kas::whereMonth('tanggal', Carbon::parse($tgl)->format('m'))
            ->whereYear('tanggal', Carbon::parse($tgl)->format('Y'))
            ->orderBy('in_out')
            ->get();

        $data = [
            'items' => $items,
            'total_masuk' => $items->where('in_out', Kas::Masuk)->sum('jumlah'),
            'total_keluar' => $items->where('in_out', Kas::Keluar)->sum('jumlah'),
        ];

        if (!$request->date) {
            $queryParams = [
                'date' => now()->format('Y-m'),
            ];
            return Inertia::render('kas/Index', compact('data', 'queryParams'));
        }

        return Inertia::render('kas/Index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $kas_options = [
            ['label' => 'Penerimaan', 'value' =>  Kas::Masuk],
            ['label' => 'Pengeluaran', 'value' =>  Kas::Keluar]
        ];

        $date = $request->date ? Carbon::parse($request->date)->format('Y-m-d') : Carbon::now()->format('Y-m-d');

        return Inertia::render('kas/Form', compact('kas_options', 'date'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KasRequest $request)
    {
        Kas::create($request->validated());
        return to_route('kas.index', ['date' => Carbon::parse($request->tanggal)->format('Y-m')]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Kas::find($id);
        $kas_options = [
            ['label' => 'Penerimaan', 'value' =>  Kas::Masuk],
            ['label' => 'Pengeluaran', 'value' =>  Kas::Keluar]
        ];

        return Inertia::render('kas/Form', compact('kas_options', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KasRequest $request, $id)
    {
        $data = Kas::find($id);
        $data->update($request->validated());
        return to_route('kas.index', ['date' => Carbon::parse($request->tanggal)->format('Y-m')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function bulkCreate()
    {
        return Inertia::render('kas/BulkForm');
    }
    public function bulkStore(Request $request)
    {

        $request->validate([
            'tanggal' => 'required|date',
            'jimpitan' => 'required',
            'iuran' => 'required',
            'sp' => 'required',
            'saldo' => 'required',
            'hutang' => 'required',
            'insiden' => 'required',
            'cadangan' => 'required',
            'lain' => 'nullable',
            'sosial' => 'nullable',
        ]);

        DB::beginTransaction();
        try {

            // MASUK 'jimpitan', 'sp', 'iuran', 'saldo'

            Kas::create([
                'tanggal' => $request->tanggal,
                'keterangan' => 'Jimpitan',
                'jumlah' => $request->jimpitan,
                'in_out' => Kas::Masuk
            ]);
            Kas::create([
                'tanggal' => $request->tanggal,
                'keterangan' => 'Piutang Masuk',
                'jumlah' => $request->sp,
                'in_out' => Kas::Masuk
            ]);
            Kas::create([
                'tanggal' => $request->tanggal,
                'keterangan' => 'Iuran Bulanan',
                'jumlah' => $request->iuran,
                'in_out' => Kas::Masuk
            ]);
            Kas::create([
                'tanggal' => $request->tanggal,
                'keterangan' => 'Saldo Bulan Sebelumnya',
                'jumlah' => $request->saldo,
                'in_out' => Kas::Masuk
            ]);

            if ($request->lain || $request->lain > 0) {
                Kas::create([
                    'tanggal' => $request->tanggal,
                    'keterangan' => 'Pendapatan lain-lain',
                    'jumlah' => $request->lain,
                    'in_out' => Kas::Masuk
                ]);
            }

            // KELUAR 'hutang', 'insiden', 'cadangan'

            if ($request->hutang && $request->hutang > 0) {
                Kas::create([
                    'tanggal' => $request->tanggal,
                    'keterangan' => 'Piutang Keluar',
                    'jumlah' => $request->hutang,
                    'in_out' => Kas::Keluar
                ]);
            }

            if ($request->insiden && $request->insiden > 0) {

                Kas::create([
                    'tanggal' => $request->tanggal,
                    'keterangan' => 'Dana Insiden',
                    'jumlah' => $request->insiden,
                    'in_out' => Kas::Keluar
                ]);
            }
            if ($request->cadangan && $request->cadangan > 0) {

                Kas::create([
                    'tanggal' => $request->tanggal,
                    'keterangan' => 'Dana Cadangan',
                    'jumlah' => $request->cadangan,
                    'in_out' => Kas::Keluar
                ]);
            }



            if ($request->sosial || $request->sosial > 0) {
                Kas::create([
                    'tanggal' => $request->tanggal,
                    'keterangan' => 'Dana Sosial',
                    'jumlah' => $request->sosial,
                    'in_out' => Kas::Keluar
                ]);
            }

            DB::commit();
            return to_route('kas.index', ['date' => Carbon::parse($request->tanggal)->format('Y-m')]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back();
        }
    }

    
}
